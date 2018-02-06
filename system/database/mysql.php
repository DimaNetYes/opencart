<?php
final class MySQL {
	private $link;
	
	public function __construct($hostname, $username, $password, $database) {
		if (!$this->link = mysqli_connect($hostname, $username, $password)) {
      		trigger_error('Error: Could not make a database link using ' . $username . '@' . $hostname);
		}

    	if (!mysqli_select_db($database, $this->link)) {
      		trigger_error('Error: Could not connect to database ' . $database);
    	}
		
		mysqli_query("SET NAMES 'utf8'", $this->link);
		mysqli_query("SET CHARACTER SET utf8", $this->link);
		mysqli_query("SET CHARACTER_SET_CONNECTION=utf8", $this->link);
		mysqli_query("SET SQL_MODE = ''", $this->link);
  	}
		
  	public function query($sql) {
		if ($this->link) {
			$resource = mysqli_query($sql, $this->link);
	
			if ($resource) {
				if (is_resource($resource)) {
					$i = 0;
			
					$data = array();
			
					while ($result = mysqli_fetch_assoc($resource)) {
						$data[$i] = $result;
			
						$i++;
					}
					
					mysqli_free_result($resource);
					
					$query = new stdClass();
					$query->row = isset($data[0]) ? $data[0] : array();
					$query->rows = $data;
					$query->num_rows = $i;
					
					unset($data);
					
					return $query;	
				} else {
					return true;
				}
			} else {
				trigger_error('Error: ' . mysqli_error($this->link) . '<br />Error No: ' . mysqli_errno($this->link) . '<br />' . $sql);
				exit();
			}
		}
  	}
	
	public function escape($value) {
		if ($this->link) {
			return mysqli_real_escape_string($value, $this->link);
		}
	}
	
  	public function countAffected() {
		if ($this->link) {
    		return mysqli_affected_rows($this->link);
		}
  	}

  	public function getLastId() {
		if ($this->link) {
    		return mysqli_insert_id($this->link);
		}
  	}	
	
	public function __destruct() {
		if ($this->link) {
			mysqli_close($this->link);
		}
	}
}
?>