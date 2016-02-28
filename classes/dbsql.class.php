<?php
class dbsql {
	
	/**
	 * Connection to the MySql database
	 *
	 * @var mysqli
	 */
	private $con = null;
	
	/**
	 * Is running in debug mode?
	 *
	 * @var bool
	 */
	private $debugMode = false;
	
	/**
	 * Number of open transactions
	 * Because MySQL does not allow transactions inside transactions,
	 * the ones that are open inside transactions are saved as savepoints.
	 */
	private $numTrans = 0;
	
	/**
	 * Construct and connect to the database.
	 *
	 * @param string $user        	
	 * @param string $password        	
	 * @param string $server        	
	 * @param string $database        	
	 * @param string $characterSet        	
	 * @param bool $debugMode        	
	 * @throws DbSqlException
	 */
	public function __construct($user, $password, $server = 'localhost', $database = NULL, $characterSet = 'utf8', $debugMode = false) {
		$con = @new mysqli ( $server, $user, $password, $database );
		if ($con->connect_errno) {
			// cannot call formatError because msqli uses different properties for connection errors
			throw new DbSqlException ( "Erro #" . $con->connect_errno . ": " . $con->connect_error );
		}
		
		$con->set_charset ( $characterSet );
		
		$this->debugMode = $debugMode;
		
		$this->con = $con;
	}
	
	/**
	 * Return a formatted error message
	 */
	private function formatError() {
		return "Error #" . $this->con->errno . ": " . $this->con->error;
	}
	
	/**
	 * Runs a query
	 *
	 * @param string $query        	
	 * @param array $params        	
	 * @return DbSqlResult
	 * @throws DbSqlException
	 */
	public function query($query, $params = null) {
		
		if (!is_string($query)){
			throw new Exception('Invalid Query');
		}
		if ($params != null){
			foreach ($params as $key => $val){
				$safeParam = $this->treatParam ($val);
				$needle = "?";
				$pos = strpos($query, $needle);
				if ($pos !== false) {
				    $query = substr_replace($query, $safeParam, $pos, strlen($needle));
				}
				
			}
		}

		$result = $this->con->query ( $query );
		if ($this->con->errno) {
			$msg = $this->formatError ();
			$msg .= ($this->debugMode) ? "<br>Query: " . $query : "";
			throw new DbSqlException ( $msg );
		}
		return new DbSqlResult ( $result );
	}
	public function execSQLCmd($cmd,$params = null) {
		$this->query ($cmd,$params);
	}
	public function lastId() {
		return mysqli_insert_id ( $this->con );
	}
	public function affectedRows() {
		return mysqli_affected_rows ( $this->con );
	}
	public function maxValue($columnName, $tableName) {
		$query = "SELECT MAX(" . $columnName . ") FROM " . $tableName . ";";
		
		$result = $this->query ( $query );
		
		$row = $result->fetchAssoc ();
		
		$maxvalue = $row ['MAX(' . $columnName . ')'];
		
		return $maxvalue;
	}
	
	public function numRecords($tableName) {
		$query = "SELECT COUNT(*) FROM " . $tableName . ";";
	
		$result = $this->query ( $query );
	
		$row = $result->fetchAssoc ();
	
		$numrecords = $row ['COUNT(*)'];
	
		return $numrecords;
	}
	
	public function startTrans() {
		if (! $this->numTrans) {
			
			$this->execSQLCmd ( "start transaction" );
		} else {
			
			$this->execSQLCmd ( "savepoint t" . ( string ) $this->numTrans );
		}
		
		$this->numTrans ++;
	}
	public function commit() {
		if ($this->numTrans > 0) {
			
			$this->numTrans --;
			
			if (! $this->numTrans) {
				
				$this->execSQLCmd ( "commit" );
			} else {
				
				$this->execSQLCmd ( "release savepoint t" . ( string ) ($this->numTrans) );
			}
		}
	}
	public function rollback() {
		if ($this->numTrans > 0) {
			
			$this->numTrans --;
			
			if (! $this->numTrans) {
				
				$this->execSQLCmd ( "rollback" );
			} else {
				
				$this->execSQLCmd ( "rollback to savepoint t" . ( string ) ($this->numTrans) );
			}
		}
	}
	
	public function treatParam ($value){
		
		// null values
		if (is_null ($value)) {
			return 'NULL';
		}
		
		//boolean values
		if (is_bool ($value)) {
			if ($value) {
				return '1';
			} else {
				return '0';
			}
		} 
		
		// string and numeric values
		if (is_string($value) || is_numeric($value)){
			return "'" . mysqli_real_escape_string($this->con,$value) . "'";
		}
		
		//array values
		if (is_array($value)){
			$arrayValue = "(";
			$i = 0;
			foreach ($value as $key => $val) {
				if ($i != 0){
					$arrayValue .= ',';
				}
				$i++;
				$arrayValue .= treatParam ($val);
			}
			$arrayValue .= ')';
			return $arrayValue;
		}
		
		//datetime values
		if (is_object($value) && $value instanceof DateTime){
			return $value ->format( 'Y-m-d H:i:s' );
		}
		
		throw new Exception('Param not treated');
		
	}
	
	/*
	 * function quoteSmart($value) {
	 *
	 *
	 *
	 * if (is_null ($value)) {
	 *
	 * return 'NULL';
	 *
	 * }
	 *
	 *
	 *
	 * // Stripslashes
	 *
	 * if (get_magic_quotes_gpc()) {
	 *
	 * $value = stripslashes($value);
	 *
	 * }
	 *
	 * if (is_bool ($value)) {
	 *
	 * if ($value) {
	 *
	 * $value = '1';
	 *
	 * } else {
	 *
	 * $value = '0';
	 *
	 * }
	 *
	 * } else {
	 *
	 * // mesmo os numeros (is_numeric) estao recebendo quotes...
	 *
	 * $value = "'" . mysql_real_escape_string($value) . "'";
	 *
	 * }
	 *
	 * return $value;
	 *
	 * }
	 *
	 *
	 *
	 * public function quoteId ($obj) {
	 *
	 * if (is_null($obj)) {
	 *
	 * return 'NULL';
	 *
	 * } else {
	 *
	 * return $this->quoteSmart($obj->getId());
	 *
	 * }
	 *
	 * }
	 *
	 *
	 *
	 * function formatDataSQL ($data, $hora = 0) {
	 *
	 *
	 *
	 * // $data deve ser do tipo timestamp
	 *
	 * // $hora deve ser 0/1, indicando se inclui a hora no retorno.
	 *
	 * // retorna uma string no formato AAAA-MM-DD ou AAAA-MM-DD hh:mm:ss ou NULL
	 *
	 *
	 *
	 * if (!$data || is_null($data)) {
	 *
	 * return 'NULL';
	 *
	 * }
	 *
	 *
	 *
	 * $format = "Y-m-d";
	 *
	 * if ($hora) {
	 *
	 * $format .= " H:i:s";
	 *
	 * }
	 *
	 *
	 *
	 * return ("'" . date ($format, $data) . "'");
	 *
	 *
	 *
	 * }
	 *
	 *
	 *
	 * /**
	 *
	 * Le uma data no formato SQL e a retorna com tipo timestamp.
	 *
	 * @param string $data data no formato SQL
	 *
	 * @return timestamp
	 *
	 */
	/*
	 * function leDataSQL ($data) {
	 *
	 *
	 *
	 * if (!$data || $data == NULL || $data == 'NULL') {
	 *
	 * return NULL;
	 *
	 * }
	 *
	 *
	 *
	 * return (strtotime ($data));
	 *
	 *
	 *
	 * }
	 *
	 *
	 *
	 * /**
	 *
	 * Le uma data no formato SQL e retorna uma string no formato DD-MM-AAAA ou DD-MM-AAAA hh:mm:ss ou ''.
	 *
	 * @param string $data data no formato SQL
	 *
	 * @param boolean $hora indica se a string retornada deve incluir a hora ou nao
	 *
	 * @return string
	 *
	 */
	/*
	 * function formatDataDoSQL ($data, $hora = 0) {
	 *
	 *
	 *
	 * if (!$data || $data == NULL || $data == 'NULL') {
	 *
	 * return '';
	 *
	 * }
	 *
	 *
	 *
	 * $groups = array();
	 *
	 * $ret = preg_match("/^(\d{2,4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})\s*(\d{1,2})\:(\d{1,2})\:(\d{1,2})$/", $data, $groups);
	 *
	 * if ($ret != 1) {
	 *
	 * return '';
	 *
	 * }
	 *
	 *
	 *
	 * $ano = $groups[1];
	 *
	 * $mes = $groups[3];
	 *
	 * $dia = $groups[5];
	 *
	 *
	 *
	 * $str = $dia . "/" . $mes . "/" . $ano;
	 *
	 *
	 *
	 * if ($hora) {
	 *
	 * $hh = $groups[6];
	 *
	 * $min = $groups[7];
	 *
	 * $seg = $groups[8];
	 *
	 * $str .= " " . $hh . ":" . $min . ":" . $seg;
	 *
	 * }
	 *
	 * return ($str);
	 *
	 *
	 *
	 * }
	 *
	 *
	 *
	 * function converteParaLista ($resultado, $campo) {
	 *
	 * $lista = "";
	 *
	 * while($row = $this->fetchAssoc($resultado)) {
	 *
	 * if ($lista != "") {
	 *
	 * $lista .= ", ";
	 *
	 * }
	 *
	 * $lista .= $this->quoteSmart($row[$campo]);
	 *
	 * }
	 *
	 * return $lista;
	 *
	 * }
	 */
}

/**
 * This class encapsulates the returned values from a query
 */
class DbSqlResult {
	
	/**
	 *
	 * @var msqli_result
	 */
	private $result;
	
	public function __construct($result) {
		$this->result = $result;
	}
	
	/**
	 * Return an associative array with the next row.
	 */
	public function fetchAssoc() {
		return $this->result->fetch_assoc ();
	}
	
	/**
	 * Return the number of rows returned from the query
	 */
	public function numRows() {
		return $this->result->num_rows;
	}
	
	/**
	 * Has the query returned any rows?
	 */
	public function hasRows() {
		return ($this->result->num_rows > 0);
	}
	
	/**
	 * Free the query result (will not be used anymore)
	 */
	public function free() {
		return $this->result->free ();
	}
}

/**
 * This class differentiates errors coming from the database.
 */
class DbSqlException extends Exception {
}
?>