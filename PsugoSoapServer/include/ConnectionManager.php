<?php
include_once("config.php");

class ConManager{
	var $db_handle;
	
	function getConnection(){
		if(USE_MYSQL == "true"){
		    //change to your database server/user name/password
			$this->db_handle = mysql_connect(SERVER,USER,PW) or die("Could not connect: " . mysql_error());
	
			//change to your database name
			mysql_select_db(DB) or die("Could not select database: " . mysql_error());
			
			mysql_query("SET NAMES 'utf8'");
		}
		else
			$this->db_handle = pg_connect("host=localhost dbname=completions user=jean password=canada01");
		return $this->db_handle;
	}
	
	function query($query){
		if($myfile = fopen("debug.log", "a+" )) {
			if(strlen($query) > 1000){
				fputs($myfile, date("Y/m/d H:i:s").":".substr($query, 0, 80));
				fputs($myfile, ".... TRUNCATED ....".substr($query, strlen($query) - 80, 80));
			}
			else
				fputs($myfile, date("Y/m/d H:i:s").":".$query);
			fputs($myfile, "\n");
			fclose($myfile);
		}

		if(USE_MYSQL == "true")
			$result = mysql_query($query);
		else
			$result = pg_query($this->db_handle, $query);
		return $result;
	}
	
	function fetch($result){
		if(USE_MYSQL == "true")
			$row = mysql_fetch_array($result);
		else
			$row = pg_fetch_assoc($result);
		return $row;
	}
	function error(){
		if(USE_MYSQL == "true")
			return mysql_error();
		else
			return pg_last_error();
	}
	function freeresult($result){
		if(USE_MYSQL == "true")
			mysql_free_result($result);
		else
			pg_freeresult($result);
	}
	function close(){
		if(USE_MYSQL == "true")
			mysql_close($this->db_handle);
		else
			pg_close($this->db_handle);
	}
}
?>