<?php
	class Database{
	
		public  $host 	   = "localhost";
		public  $username  = "root";
		public  $password  = "";
		public  $database  = "roman";
		public  $connection = false;
		public  $resultSet  = false;
		
		public function __construct(){
			if(!$this->connection)
				$this->connect();
		}
		
		public function connect(){
					
			$stat = mysql_connect($this->host, $this->username, $this->password);
			$this->connection = $stat;
			mysql_select_db($this->database);		
			mysql_query("SET names UTF8");
			return $this->connection;
		}		
		
		public function query($query){	
				
			$stat = mysql_query($query);			
			$this->resultSet = $stat;
			return $this->resultSet;
		}
		
		protected function getFieldValue($tableName, $fieldName, $filter=NULL){
			
			$result = $this->getRowValue($tableName, $fieldName, $filter);					
			return $result[$fieldName];		
		}		
		
		public function getRow($index=0){
			$count = 0;
			if($this->resultSet){
				$count = mysql_num_rows($this->resultSet);
			}
			
			if($count>0 && $index>=0 && $index<$count){
				mysql_data_seek($this->resultSet, $index);
				return mysql_fetch_assoc($this->resultSet);
			}else{
				return false;
			}
		}
	
		public function getResultAsArray($key=""){
			$array = array();
			while($row = mysql_fetch_assoc($this->resultSet)){
				if($key=="")
					$array[] = $row;
				else
					$array[$row[$key]] = $row;
			}
			return $array;
		}
	
		public function getResultAsSelect($value="id", $text="id", $default=null, $attributes=NULL, $first=array(), $last=array()){			
		
			$select = "<select $attributes >\n";
			if(!empty($first)){
				$select .= "<option value='".$first['value']."'>".$first['text']."</option>";
			}
			$rowCount = 1; 
			if($this->resultSet){
				while($row = mysql_fetch_assoc($this->resultSet)){
					$select .= "\t<option value='".$row[$value]."' ";
								if(is_array($default)){
									$select .= ((in_array($row[$value], $default)) ? 'selected=selected':'');
								}else{
							   		$select .= ($row[$value]==$default ? 'selected=selected':'');
							   	}
					$select .= " class=".optionRows($rowCount++).">".$row[$text]."</option>\n";
				}
			}
			if(!empty($last)){
				$select .= "<option value='".$last['value']."'>".$last['text']."</option>";
			}
			$select .= "</select>";
		
			return $select;
		}
		
		protected function getRowValue($table_name, $field, $filter=NULL, $order=NULL){		
			$this->execSQL($table_name, $field, $filter, $order, '1');		
			return $this->getRow();			
		}
		
		protected function getAllRows($table_name, $field, $filter=NULL, $order=NULL, $limit=NULL){			
			$this->execSQL($table_name, $field, $filter, $order, $limit);
			return $this->getResultAsArray();					
		}
		
		protected function getSelectList($table_name, $field, $filter, $order, $limit, $value, $text, $default=NULL, $attributes=NULL,$first=NULL, $last=NULL){
			$this->execSQL($table_name, $field, $filter, $order, $limit);
			return $this->getResultAsSelect($value,$text,$default,$attributes,$first,$last);
		}
		
		protected function buildQuery($table_name, $field, $filter=NULL, $order=NULL, $limit=NULL){
			
			$sql = "SELECT ".$field." FROM ".$table_name;
			if($filter != '')
				$sql .= " WHERE ".$filter;
			if($order != '')
				$sql .= " ORDER BY ".$order;
			if($limit != '')
				$sql .= " LIMIT ".$limit;

			//echo $sql."<br/>";
			return $sql;							
		}

		protected function execSQL($table_name, $field, $filter=NULL, $order=NULL, $limit=NULL){
			
			$sql = $this->buildQuery($table_name, $field, $filter, $order, $limit);
			return $this->query($sql);							
		}
		
		protected function countRow($tablename, $filter=NULL){	
							
			$sql = "SELECT IFNULL(COUNT(1), 0) AS cnt
					FROM ".$tablename;
			if($filter != '')
				$sql .= " WHERE ".$filter;																	
			$this->query($sql);				
			$row = $this->getRow();		
			return $row['cnt'];
		}
		
		protected function insertIntoDB($table_name, $fields) {			
			
			$magic_on = get_magic_quotes_gpc();
			$col = "";
			$data = "";	
			if($fields){		
				foreach ($fields as $key => $value) {
					$col .= $key.",";				
					if($magic_on){
						$value = stripslashes($value);
					}				
					$value = trim($value);
					$data .= "'".mysql_real_escape_string($value, $this->connection)."',";
				}			
			}
			$sql = "INSERT INTO $table_name (".rtrim($col, ",").") VALUES(".rtrim($data, ",").")"; 
			
			//echo $sql;
			//die();

			$this->query($sql);
			return mysql_insert_id();
		}
		
		protected function updateDB($table_name, $fields, $filters) {			
			
			$magic_on = get_magic_quotes_gpc();
			$updates = "";			
			foreach ($fields as $key => $value) {
				if($magic_on){
					$value = stripslashes($value);
				}
				$value = trim($value);
				$updates .= $key."='".mysql_real_escape_string($value)."',";
			}			
			$sql = "UPDATE $table_name SET ".rtrim($updates, ",")." ";			
			if($filters!=""){
				$sql .= "WHERE $filters";
			}	

			//echo $sql;					
			return $this->query($sql);
		}
		
		protected function deleteFromDB($table_name, $filters) {			
			
			$sql = "DELETE FROM $table_name ";			
			if($filters!=""){
				$sql .= "WHERE $filters";
			}			
			return $this->query($sql);				
		}
		
	}
?>