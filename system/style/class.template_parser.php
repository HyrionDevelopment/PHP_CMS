<?php
class Template_parser
{
	private $hyrionParser;

	public function __construct()
	{
		$this->hyrionParser = new hyrion_Parser();
	}

	public function parse($filename,$data=null)
	{
		$data = ($data === null)? array(): $data;
		$this->hyrionParser->parse($filename,$data);
		return $this->hyrionParser->getContent();
	}
	
	public function LoadViewer($filename,$data=null)
	{
		$URI_index = new URI_index();
		$seg = $URI_index->get_segments();
		$filename = "apps/".$seg[1]."/viewer/".$filename;
		$data = ($data === null)? array(): $data;
		$this->hyrionParser->parse($filename,$data);
		return $this->hyrionParser->getContent();
	}

	function get_file($filename)
	{
		$filename = $filename.".php";
		if(file_exists($filename))
		{
			return file_get_contents($filename);
		}else{
			return false;
		}
	}
	
	function start_parce($content,$data)
	{
		
		if($content == '' || empty($content))
		{
			//Als er geen content is dan return False
			return false;
		}
		
		foreach($data as $key => $val)
		{
			if(!is_array($val))
			{
				//echo $key;
				
					$content = $this->parse_one($key,$val,$content);	
									
			}
			else
			{
				//als er meerdere values zijn in de array
				$content = $this->parse_array($key,$val,$content);
			}
		}
		
		return $content;
	}
	
	function parse_one($key, $val, $content)
	{
		$key = "{".$key."}";
		return str_replace($key, $val, $content);
	}
	
	function parse_array($var,$data,$content)
	{
		if (false === ($match = $this->match($content, $var)))
		{
			return $content;
		}
		$data_all = '';
		if(!empty($data))
		{
			foreach($data as $value)
			{
				$cache = $match['1'];
				foreach($value as $key => $val)
				{
					if(is_array($val))
					{
						$cache = $this->parse_array($key,$val,$cache);
					}else{
						$cache = $this->parse_one($key,$val,$cache);
					}
				}
				$data_all .= $cache;
			}
		}
		return str_replace($match['0'], $data_all, $content);
	}
	
	function match($content, $var)
	{
		// if(!preg_match("|{".$var."}(.+?){/".$var."}|s", $content, $match))
		if (!preg_match("|".preg_quote("{").$var.preg_quote("}")."(.+?)".preg_quote("{").'/' .$var.preg_quote("}")."|s", $content, $match))
		{
			return FALSE;
		}else{
			return $match;
		}
	}
}