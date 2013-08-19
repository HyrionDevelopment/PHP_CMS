<?php
class Database
	{
		/**
		 * This variable is for database handle
		 *
		 * @since 2.1
		 * @access private
		 * @author Kevin van Steijn
		 */
		private static $_dbh = FALSE;
		
		/**
		 * This variable is for PDO handle
		 *
		 * @since 2.1
		 * @access private
		 * @author Kevin van Steijn
		 */
		private static $_sth;

		/**
		 * This variable is for database state
		 *
		 * @since 2.1
		 * @access private
		 * @author Kevin van Steijn
		 */
		private static $_error = array();

		/**
		 * This variable is for the storage of database driver
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		public static $driver = 'mysql';

		/**
		 * This variable is for the storage of database host
		 * Add here the path when using SQLite
		 *
		 * @since 2.1
		 * @access public
		 * @author Maarten Oosting
		 */
		public static $host = 'localhost';
		
		/**
		 * This variable is for the storage of database username
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		public static $user = '';
		
		/**
		 * This variable is for the storage of database password
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		public static $password = '';
		
		/**
		 * This variable is for the storage of databasename
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		public static $name = '';
		
		/**
		 * - 
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn, Maarten Oosting
		 */
		public function __construct($db_driver = FALSE, $db_user = FALSE, $db_password = FALSE, $db_name = FALSE, $db_host = FALSE)
		{	
			try {
				//Check argument. When not given using defaults
				if (!$db_driver) $db_driver = self::$driver;
				if(empty($db_driver)) throw new PDOException('Driver not available');
				
				if (!$db_host) $db_host = self::$host;
				if (!$db_name) $db_name = self::$name;
				if (!$db_user) $db_user = self::$user;
				if (!$db_password) $db_password = self::$password;

				//Checking Database driver
				if ($db_driver == 'sqlite') {
					$dbh = new PDO($db_driver.':'.$db_host);
				}elseif($db_driver == 'oci'){
					$dbh = new PDO($db_driver.':', $db_user, $db_password);
				}else if($db_driver == 'mysql' || $db_driver == "pgsql"){
					$dbh = new PDO($db_driver.':host='.$db_host.';dbname='.$db_name.';charset=utf8', $db_user, $db_password);
				} else throw new PDOException('Driver not available/supported');

				$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				self::$name = $db_name;
				self::$_dbh = $dbh;
			} 
			catch(PDOException $e) {
				self::$_dbh = FALSE;
			}
		}
		
		/**
		 * Get connect status
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		public static function GetConnectStatus()
		{
			return (self::$_dbh) ? TRUE : FALSE;
		}
		
		/**
		 * Filter a string
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		public static function Filter($string)
		{
			$arguments = array('\t', '\r', '\o', '\x0B', '\x00', '\x1a');
			$string = str_replace($arguments, '', strip_tags($string));
			$string = stripslashes($string);
			
			return $string;
		}
		
		/**
		 * Execute SQL query
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn, Maarten Oosting
		 */
		public static function Query($sql)
		{
			try {
				$dbh = self::$_dbh;
				if (!$dbh) throw new PDOException('No database connection');
				
				$object = $dbh->prepare($sql); 
				return $object;
			} catch(PDOException $e) {
				throw $e;
			} 
		}
		
		/**
		 * -
		 *
		 * @since 2.1
		 * @access public
		 * @author Stefan de Bruin
		 */
		private static function GetFetch($tablename, $select_arg, $where_arg, $order_by, $sort, $where_insertion)
		{
			if (!is_array($tablename)) $tablename = array($tablename);
			if (!is_array($select_arg)) $select_arg = array($select_arg);
			if (!is_array($where_arg)) $where_arg = array('id' => $where_arg);
			if (!in_array($where_insertion, array('AND', 'OR'))) $where_insertion = 'AND';
			
			$sql = 'SELECT ' .implode(', ', $select_arg) .' FROM ' .implode(' ,', $tablename);
	
			$where_total = count($where_arg);
			if ($where_total > 0) {
				$sql .= ' WHERE ';
				$sql .= self::SetInSQL($where_total, $where_arg, $where_insertion);
			}

			if ($order_by){
				$sql .= ' ORDER BY ';
				$sql .= $order_by;
				if (!in_array($sort, array('ASC', 'DESC'))) $sort = 'ASC';
				$sql .= ' ' . $sort;
			}
            
			$sth = self::$_dbh->prepare($sql);
			
			if ($where_total > 0)
				self::SetBlindValue($sth, $where_total, $where_arg);
			
			return self::Execute($sth);
		}
		
		/**
		 * -
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn, Maarten Oosting
		 */
		public static function GetSingle($tablename, $where_arg, $select = '*', $where_insertion = 'AND')
		{
			try {
				$dbh = self::$_dbh;
				if (!$dbh) throw new PDOException('No database connection');
				
				$sth = self::GetFetch($tablename, $select, $where_arg, FALSE, FALSE, $where_insertion);
				$arguments = $sth->fetch(PDO::FETCH_ASSOC);
				
				return $arguments;
			} catch(PDOException $e) {
				throw $e;
			}
		}
		
		/**
		 * -
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn, Maarten Oosting, Stefan de Bruin
		 */
		public static function GetArray($tablename, $select = '*', $where_arg = array(), $order_by = FALSE, $sort = 'ASC', $where_insertion = 'AND')
		{
			try{
				$dbh = self::$_dbh;
				if (!$dbh) throw new PDOException('No database connection');
				
				$sth = self::GetFetch($tablename, $select, $where_arg, $order_by, $sort, $where_insertion);
				$arguments = $sth->fetchAll(PDO::FETCH_ASSOC);
				return $arguments;
			} catch(PDOException $e){
				throw $e;
			}	
		}
		
		/**
		 * Search in a table
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		public static function Search($tablename, $like_arg, $where_arg = array(), $select_arg = '*')
		{
			try {
				$dbh = self::$_dbh;
				if (!$dbh) throw new PDOException('No database connection');
				
				if (!is_array($tablename)) $tablename = array($tablename);
				if (!is_array($like_arg)) $update_arg = array('id' => $update_arg);
				if (!is_array($where_arg)) $where_arg = array('id' => $where_arg);
				if (!is_array($select_arg)) $select_arg = array($select_arg);
				
				$like_total = count($like_arg);
				if ($like_total == 0) throw new PDOException('LIKE is empty'); 
				
				$sql = 'SELECT ' .implode(', ', $select_arg) .' FROM ' .implode(' ,', $tablename) . ' WHERE (';
				$sql .= self::SetInSQL($like_total, $like_arg, 'OR', 'LIKE') . ')';
				
				$where_total = count($where_arg);
				if ($where_total > 0)
					$sql .= ' AND (	' . self::SetInSQL($where_total, $where_arg, 'AND') . ')';
				
				$sth = $dbh->prepare($sql);
				
				self::SetBlindValue($sth, $like_total, $like_arg);
				
				if ($where_total > 0)
					self::SetBlindValue($sth, $where_total, $where_arg, $like_total);
				
				$sth = self::Execute($sth);
				
				return $sth->fetchAll(PDO::FETCH_ASSOC);
			} catch(PDOException $e) { 
				throw $e;
			}
		}
		
		/**
		 * Create and execute a SQL update query
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn, Maarten Oosting
		 */
		public static function Update($tablename, $update_arg, $where_arg = array())
		{
			try {
				$dbh = self::$_dbh;
				if (!$dbh) throw new PDOException('No database connection');
				
				if (!is_array($tablename)) $tablename = array($tablename);
				if (!is_array($update_arg)) $update_arg = array('id' => $update_arg);
				if (!is_array($where_arg)) $where_arg = array('id' => $where_arg);
				
				$update_keys = array_keys($update_arg);
				$update_total = count($update_arg);
				$sql = 'UPDATE ' . implode('.', $tablename) . ' SET ';
				for($i = 0; $i < $update_total; $i++) {
					$sql .= $update_keys[$i] . ' = ?';
					if (($i + 1) < $update_total) $sql .= ',';
				}
				
				$where_total = count($where_arg);
				if ($where_total > 0) {
					$sql .= ' WHERE ';
					$sql .= self::SetInSQL($where_total, $where_arg, 'AND');
				}
	
				$sth = $dbh->prepare($sql);
				
				self::SetBlindValue($sth, $update_total, $update_arg);
				
				if ($where_total > 0)
					self::SetBlindValue($sth, $where_total, $where_arg, $update_total);
				
				self::Execute($sth);
				
				return TRUE;
			} catch(PDOException $e) { 
				throw $e;
			}
		}
		
		/**
		 * Create and execute a SQL insert query
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn, Maarten Oosting
		 */
		public static function Insert($tablename, $arguments)
		{
			try {
				$dbh = self::$_dbh;
				if (!$dbh) throw new PDOException('No database connection'); 
				
				if (!is_string($tablename)) throw new PDOException('Tablename is not a string'); 
				if (!is_array($arguments)) $arguments = array('id' => $arguments);
				
				$keys = array_keys($arguments);
				$total = count($arguments);
				$sql = "INSERT INTO $tablename (";
				$values = '';
				for ($i = 0; $i < $total; $i++) {
					$sql .= $keys[$i];
					$values .= '?';
					if (($i + 1) < $total) {
						$sql .= ',';
						$values .= ',';
					}
				}
				$sql .= ") VALUES ($values)";
				
				$sth = $dbh->prepare($sql);
				
				self::SetBlindValue($sth, $total, $arguments);
				self::Execute($sth);
				
				return $dbh->lastInsertId();
			} catch(PDOException $e) {
				throw $e;
			}
		}
		
		/**
		 * Delete and execute
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn, Maarten Oosting
		 */
		public static function Delete($tablename, $arguments)
		{
			try {
				$dbh = self::$_dbh;
				if (!$dbh) throw new PDOException('No database connection');
				
				if (!is_string($tablename)) throw new PDOException('Tablename is not a string'); 
				if (!is_array($arguments)) $arguments = array('id' => $arguments);
				
				$total = count($arguments);
				if ($total == 0) throw new PDOException('WHERE is empty'); 
				
				$sql = "DELETE FROM $tablename WHERE ";
				$sql .= self::SetInSQL($total, $arguments, 'AND');
				
				$sth = $dbh->prepare($sql);
				
				self::SetBlindValue($sth, $total, $arguments);
				self::Execute($sth);
				
				return TRUE;
			} catch(PDOException $e) { 
				throw $e;
			}	
		}
		
		/**
		 * Get backup of the database
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		public static function Backup()
		{
			$output = '';
			$list = self::GetTableList();
			foreach ($list as $name) {
				$columns = self::GetTableColumns($name);
				$total = count($columns);
				$primary = FALSE;
				
				$output .= "CREATE TABLE $name(" . PHP_EOL;
				foreach ($columns as $i => $row) {
					$output .= $row['Field'] . " " . strtoupper($row['Type']) . " ";
					if ($row['Extra'] !== 'auto_increment') {
						$output .= ($row['Null'] == 'NO') ? "NOT NULL DEFAULT '{$row['Default']}'" : "DEFAULT NULL";
						if (!empty($row['Extra'])) $output .= " " . strtoupper($row['Extra']);	
					} else $output .= "NOT NULL AUTO_INCREMENT";
					
					if (($i + 1) < $total) $output .= ',' . PHP_EOL;
					if ($row['Key'] == 'PRI') $primary = $row['Field'];
				}
				
				if ($primary) $output .=  "," . PHP_EOL . "PRIMARY KEY ($primary)";
				$output .= PHP_EOL . ")";
				
				
				$output .= ";" . PHP_EOL . PHP_EOL;
			}
			
			// echo nl2br($output);
		}
		
		/**
		 * Get list of tables
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		public static function GetTableList()
		{
			try {
				$dbh = self::$_dbh;
				if (!$dbh) throw new PDOException('No database connection');
				
				$sth = $dbh->query("SHOW TABLES");
				$list = $sth->fetchAll(PDO::FETCH_ASSOC);
				foreach ($list as $key => $value) {
					$name = key($value);
					$list[$key] = $value[$name];
				}	
				
				return $list;
			} catch(PDOException $e) {
				throw $e;
			}
		}
		
		/**
		 * Get columns of a table
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		public static function GetTableColumns($name)
		{
			try {
				$dbh = self::$_dbh;
				if (!$dbh) throw new PDOException('No database connection');
				
				$sth = $dbh->query("SHOW COLUMNS IN $name");
				$arguments = $sth->fetchAll(PDO::FETCH_ASSOC);
				
				return $arguments;
			} catch(PDOException $e) {
				throw $e;
			}	
		}
		
		/**
		 * Get information of a table
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		public static function GetTableInfo($name)
		{
			try {
				$dbh = self::$_dbh;
				if (!$dbh) throw new PDOException('No database connection');
				
				$sth = $dbh->query("SHOW COLUMNS IN $name");
				$arguments = $sth->fetchAll(PDO::FETCH_ASSOC);
				
				return $arguments;
			} catch(PDOException $e) {
				throw $e;
			}	
		}
		
		/**
		 * Get total of execute
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		public static function GetTotal()
		{
			return self::$_sth->rowCount();
		}
		
		/**
		 * Execute and set data in class
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		private static function Execute($sth)
		{
			$sth->execute();
			self::$_sth = $sth;
			
			return $sth;
		}
		
		/**
		 * Create a SQL query
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		private static function SetInSQL($total, $arguments, $type, $insertion = '=')
		{
			$keys = array_keys($arguments);
			$sql = '';
			for ($i = 0; $i < $total; $i++) {
				$sql .= $keys[$i] . " $insertion ?";
				if (($i + 1) < $total) $sql .= " $type ";
			}
			
			return $sql;
		}
		
		/**
		 * Set data in bindValue
		 *
		 * @since 2.1
		 * @access public
		 * @author Kevin van Steijn
		 */
		private static function SetBlindValue($sth, $total, $arguments, $key = 0)
		{
			$values = array_values($arguments);
			for ($i = 0; $i < $total; $i++) {
				$sth->bindValue(($key + $i + 1), self::Filter($values[$i]));
			}
		} 
	}