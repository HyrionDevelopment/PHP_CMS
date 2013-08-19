<?php

	/**
	 * Hyrion Parser
	 * Copyright (C) 2012 Maarten Oosting & Kevin van Steijn
	 *
	 * This program is free software; you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation; either version 2 of the License, or
	 * (at your option) any later version.
	 * 
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License along
	 * with this program; if not, write to the Free Software Foundation, Inc.,
	 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
	 */
	class Hyrion_parser
	{
		/**
		 * This variable is for saving the output
		 *
		 * @since 1.0
		 * @access private
		 * @author Maarten Oosting
		 */
		private $content = FALSE;

		/**
		 * This variable is for set the prefix and suffix
		 *
		 * @since 1.0
		 * @access public
		 * @author Maarten Oosting
		 */
		public $p_prefix = '{';
		public $p_suffix = '}';

		/**
		 * This variable is for calling the classname of the parser functions
		 *
		 * @since 1.0
		 * @access private
		 * @author Maarten Oosting
		 */
		private $classname_parserfunctions = FALSE;
		
		/**
		 * A memory for the action of the if parser
		 *
		 * @since 2.0
		 * @access private
		 * @author Kevin van Steijn
		 */
		private $if_action = TRUE;
		
		/**
		 * A memory for the amount of the if parser
		 *
		 * @since 2.0
		 * @access private
		 * @author Kevin van Steijn
		 */
		private $if_false = 0;
		
		/**
		 * A memory for the action of the else in if parser
		 *
		 * @since 2.0
		 * @access private
		 * @author Kevin van Steijn
		 */
		private $if_else = FALSE;
		
		/**
		 * A memory for a list of content for the if parser
		 *
		 * @since 2.0
		 * @access private
		 * @author Kevin van Steijn
		 */
		private $temp = array();

		/**
		 * Constructor
		 *
		 * @since 1.0
		 * @access public
		 * @author Maarten Oosting
		 */
		public function __construct()
		{
			/**
			 * UpdateCheck
			 * Copyright (C) 2012 KvanSteijn
			 */
				//UpdateCheck::SetUpdate('http://hyrion.com/updates/parser/standalone/', 1.1);
			/**
			 * End UpdateCheck
			 */
		}

		/**
		 * setFunctionClass
		 * You can set the class name for the function Class
		 *
		 * @since 1.0
		 * @access public
		 * @author Maarten Oosting
		 */

		public function setFunctionClass($class)
		{
			$this->classname_parserfunctions = $class;
		}

		/**
		 * Parse
		 * You can call this function for parse a file
		 *
		 * @since 1.0
		 * @access public
		 * @author Maarten Oosting
		 */
		public function parse($filename, $data)
		{
			try {
				$action = false;
				if (!empty($filename) && is_array($data)) {
					if ($content = $this->get_file($filename)) {					
						//Hier returnt hij de content naar de controller
						$class = $this->get_class();
						$content = $this->ParseCalledFunctions($content, $class);				
						$content = $this->parce_ifs($content, $class);
						if ($content = $this->start_parce($content, $data)) {
							$this->content = $content;
							$action = true;
						}
					}
				}
				return $action;
			} catch (Exception $e) {
				print_r($e->getMessage());
				exit();
			}
		}

		/**
		 * getContent
		 * This function return the parsered content
		 *
		 * @since 1.0
		 * @access public
		 * @author Maarten Oosting
		 */			
		public function getContent()
		{
			try{
				$content = $this->content;
				if($content) return $content;

				throw new Exception("State is false", 372);
			} catch (Exception $e) {
				print_r($e);
				exit();
			}
		}

		/**
		 * get_files
		 *
		 * @since 1.0
		 * @access private
		 * @author Maarten Oosting
		 */		
		private function get_file($filename)
		{
			if (file_exists($filename)) {
				return file_get_contents($filename);
			} else return false;
		}

		/**
		 * Start_parce
		 * Check if content is a arrray
		 *
		 * @since 1.0
		 * @access private
		 * @author Maarten Oosting
		 */			
		private function start_parce($content,$data)
		{
			foreach($data as $key => $val)
			{
				if (is_array($val)) {
					$content = $this->parse_array($key,$val,$content);		
				} else $content = $this->parse_one($key,$val,$content);
			}

			return $content;
		}

		/**
		 * Parse the single content
		 *
		 * @since 1.0
		 * @access private
		 * @author Maarten Oosting
		 */			
		private function parse_one($key, $val, $content)
		{
			$key = $this->p_prefix . $key . $this->p_suffix;
			return str_replace($key, $val, $content);
		}


		/**
		 * Parse the array content
		 *
		 * @since 1.0
		 * @access private
		 * @author Maarten Oosting
		 */	
		private function parse_array($var,$data,$content)
		{
			$match = $this->match($content, $var);
			if ($match == false) return $content;

			$data_all = '';
			foreach($data as $value) {
				if (is_array($value)) {
					$cache = $match['1'];
					foreach($value as $key => $val) {
						if (is_array($val)) {
							$cache = $this->parse_array($key,$val,$cache);
						} else $cache = $this->parse_one($key,$val,$cache);
					}
					$data_all .= $cache;
				}
			}

			return str_replace($match['0'], $data_all, $content);
		}

		/**
		 * -
		 *
		 * @since 1.0
		 * @access private
		 * @author Maarten Oosting
		 */	
		private function match($content, $var)
		{
			$p_prefix = $this->p_prefix;
			$p_suffix = $this->p_suffix;

			if (preg_match("|". $p_prefix . $var . $p_suffix . "(.+?)" . $p_prefix . '/' . $var . $p_suffix . "|s", $content, $match))
				return $match;
				
			return FALSE;
		}
		
		/**
		 * Get class 
		 *
		 * @since 2.0
		 * @access private
		 * @author Kevin van Steijn
		 */
		private function get_class()
		{
			$classname = $this->classname_parserfunctions;
			if (empty($classname)) $classname = 'Parser_functions'; 
			if (!class_exists($classname))
				throw new Exception("Called function class is not a (valid) class", 458);
			
			return new $classname();
		}
		
		/**
		 * Parse TRUE or FALSE to a string
		 *
		 * @since 2.0
		 * @access private
		 * @author Kevin van Steijn
		 */
		private function convert_to_string($output)
		{
			if (is_bool($output) === TRUE) {
				$output = var_export($output, TRUE);
				$output = strtoupper("$output");	
			}
			
			return $output;
		}

		/**
		 * Parse the IF statments
		 *
		 * @since 1.0
		 * @access private
		 * @author Maarten Oosting & Kevin van Steijn
		 */		
		private function parce_ifs($content, $class)
		{
			$content_array = explode(PHP_EOL, $content);
			foreach ($content_array as $key => $value) {
				if (preg_match("|".preg_quote ('<!-- IF ').'(.+?)'.preg_quote ('-->')."|s", $value, $match1)) {
					if ($this->if_action) {
						if (preg_match("|(.+?)\((.+?)\) \=\= ([A-Za-z0-9]{1,})(.+?)|s", $match1[1], $match2)) {
							$action = TRUE;
							$output1 = $class->$match2[1]($match2[2]);
							$output2 = $match2[3];
						} else if (preg_match("|(.+?)\(\) \=\= ([A-Za-z0-9]{1,})(.+?)|s", $match1[1], $match2)){
							$action = TRUE;
							$output1 = $class->$match2[1]();
							$output2 = $match2[2];
						} else $action = FALSE;
						
						if ($action) {
							if ($this->convert_to_string($output1) !== $output2) {
								$this->if_action = FALSE;
								$this->if_false++;
							} else $this->if_action = TRUE;
							
							unset($content_array[$key]);
							continue;
						}
					}
					
					unset($content_array[$key]);
				}

				if ($this->if_action) {
					if (preg_match("|".preg_quote ('<!-- ELSE -->')."|s", $value)) {
						$this->if_else = TRUE;
						unset($content_array[$key]);
					} else if (preg_match("|".preg_quote ('<!-- IF ').'(.+?)'.preg_quote ('-->')."|s", $value)) {
						unset($content_array[$key]);
					} else if(preg_match("|".preg_quote ('<!-- END IF -->')."|s", $value)) {
						$this->if_else = FALSE;
						unset($content_array[$key]);
					} else if ($this->if_else) unset($content_array[$key]);
				} else {
					if (isset($content_array[$key])) $this->temp[$key] = $content_array[$key];
					if (preg_match("|".preg_quote ('<!-- ELSE -->')."|s", $value)) {
						$this->if_else = TRUE;
						$content_array = $this->RemoveLines($content_array, $this->temp);
						$this->temp = array();
					} else if (preg_match("|".preg_quote ('<!-- IF ').'(.+?)'.preg_quote ('-->')."|s", $value)) {
						$this->if_false++;
					} else if(preg_match("|".preg_quote ('<!-- END IF -->')."|s", $value)) {
						if (!$this->if_else)
							$content_array = $this->RemoveLines($content_array, $this->temp); 
						
						$this->if_else = FALSE;
						$this->if_false--;
						
						if ($this->if_false == 0) {
							$this->if_action = TRUE;
							$this->temp = array();	
						}
					}
				}
			}
			
			return implode(PHP_EOL, $content_array);
		}
		
		/**
		 * Remove lines in a array
		 *
		 * @since 2.0
		 * @access private
		 * @author Kevin van Steijn
		 */
		private function RemoveLines($arguments1, $arguments2)
		{
			foreach ($arguments2 as $key => $value)
				unset($arguments1[$key]);
			
			return $arguments1;
		}

		private function ParseCalledFunctions($content, $class)
		{
			if (preg_match_all("|".preg_quote ('<!-- LOAD_FUNCTION[')."(.+?)".preg_quote ('] -->')."|s", $content, $match)) {
				foreach ($match[0] as $key1 => $val1) {
					$output_function = '';
					$function_name = $match[1][$key1];
					$output_function = $class->$function_name();
					$content = str_replace($val1, $output_function, $content);
				}
			}
			return $content;
		}
	}
?>
