<?php

 

require_once DIR_RAIZ . 'lib/configAplicacao.php';

 

class DBSql {

 

               // numero de transacoes supostamente abertas

               // como no mysql nao eh possivel abrir transacoes aninhadas, eh necessario controlar este numero.

               // as que nao sao abertas, sao salvas como savepoints.

               private $numTransactions = 0;

 

               // Link com o banco de dados.

               private $con = NULL;

 

               private function formataErroSQL () {

                              return "Erro #" . mysql_errno($this->con) . ": " . mysql_error($this->con);

               }

 

               function conecta($user, $password, $server = 'localhost', $database = NULL, $characterSet = 'utf8') {

 

                              $this->con = mysql_connect($server, $user, $password);

 

                              if (!$this->con) {

                                             // nao pode usar o metodo formataErroSQL porque $this->con nao eh valido!

                                             throw new SqlBDException ("Erro #" . mysql_errno() . ":" . mysql_error(), mysql_errno());

                              }

 

                              if (!is_null ($database)) {

                                             mysql_select_db($database, $this->con);

                              }

                              mysql_set_charset($characterSet, $this->con);

               }

 

               function execQuery($query) {

                              global $confApl;

                             

                              $ret = mysql_query($query, $this->con);

                              if (mysql_errno($this->con) != 0) {

                                             $codigo = mysql_errno($this->con);

                                             $msg = $this->formataErroSQL();

                                             $msg .= ($confApl->isModoDebug())? "<br>Query: " . $query : "";

                                             throw new SqlBDException ($msg, $codigo);

                              }

                              return $ret;

               }

 

               function execSQLCmd($cmd) {

                              $this->execQuery($cmd);

               }

 

               function fetchAssoc($result) {

                              return mysql_fetch_assoc($result);

               }

 

               function lastId() {

                              return mysql_insert_id($this->con);

               }

 

               function numRows($result) {

                              return mysql_num_rows($result);

               }

 

               function affectedRows() {

                              return mysql_affected_rows($this->con);

               }

              

               function iniciaTransacao () {

                              if (!$this->numTransactions) {

                                             $this->execSQLCmd("start transaction");

                              } else {

                                             $this->execSQLCmd("savepoint trans" . (string) $this->numTransactions);

                              }

                              $this->numTransactions++;

               }

 

               function commit () {

                              if ($this->numTransactions > 0) {

                                             $this->numTransactions--;

                                             if (!$this->numTransactions) {

                                                            $this->execSQLCmd("commit");

                                             } else {

                                                            $this->execSQLCmd("release savepoint trans" . (string) ($this->numTransactions));

                                             }

                              }

               }

 

               function rollback () {

                              if ($this->numTransactions > 0) {

                                             $this->numTransactions--;

                                             if (!$this->numTransactions) {

                                                            $this->execSQLCmd("rollback");

                                             } else {

                                                            $this->execSQLCmd("rollback to savepoint trans" . (string) ($this->numTransactions));

                                             }

                              }

               }

 

               function quoteSmart($value) {

 

                              if (is_null ($value)) {

                                             return 'NULL';

                              }

                             

                              // Stripslashes

                              if (get_magic_quotes_gpc()) {

                                             $value = stripslashes($value);

                              }

                              if (is_bool ($value)) {

                                             if ($value) {

                                                            $value = '1';

                                             } else {

                                                            $value = '0';

                                             }

                              } else {

                                             // mesmo os numeros (is_numeric) estao recebendo quotes...

                                             $value = "'" . mysql_real_escape_string($value) . "'";

                              }

                              return $value;

               }

              

               public function quoteId ($obj) {

                              if (is_null($obj)) {

                                             return 'NULL';

                              } else {

                                             return $this->quoteSmart($obj->getId());

                              }

               }

 

               function formatDataSQL ($data, $hora = 0) {

 

                              // $data deve ser do tipo timestamp

                              // $hora deve ser 0/1, indicando se inclui a hora no retorno.

                              // retorna uma string no formato AAAA-MM-DD ou AAAA-MM-DD hh:mm:ss ou NULL

 

                              if (!$data || is_null($data)) {

                                             return 'NULL';

                              }

 

                              $format = "Y-m-d";

                              if ($hora) {

                                             $format .= " H:i:s";

                              }

 

                              return ("'" . date ($format, $data) . "'");

 

               }

 

               /**

               * Le uma data no formato SQL e a retorna com tipo timestamp.

               * @param string $data data no formato SQL

               * @return timestamp

               */

               function leDataSQL ($data) {

 

                              if (!$data || $data == NULL || $data == 'NULL') {

                                             return NULL;

                              }

 

                              return (strtotime ($data));

 

               }

 

               /**

               * Le uma data no formato SQL e retorna uma string no formato DD-MM-AAAA ou DD-MM-AAAA hh:mm:ss ou ''.

               * @param string $data data no formato SQL

               * @param boolean $hora indica se a string retornada deve incluir a hora ou nao

               * @return string

               */

               function formatDataDoSQL ($data, $hora = 0) {

 

                              if (!$data || $data == NULL || $data == 'NULL') {

                                             return '';

                              }

 

                              $groups = array();

                              $ret = preg_match("/^(\d{2,4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})\s*(\d{1,2})\:(\d{1,2})\:(\d{1,2})$/", $data, $groups);

                              if ($ret != 1) {

                                             return '';

                              }

 

                              $ano = $groups[1];

                              $mes = $groups[3];

                              $dia = $groups[5];

 

                              $str = $dia . "/" . $mes . "/" . $ano;

 

                              if ($hora) {

                                             $hh = $groups[6];

                                             $min = $groups[7];

                                             $seg = $groups[8];

                                             $str .= " " . $hh . ":" . $min . ":" . $seg;

                              }

                              return ($str);

 

               }

              

               function converteParaLista ($resultado, $campo) {

                              $lista = "";

                              while($row = $this->fetchAssoc($resultado)) {

                                             if ($lista != "") {

                                                            $lista .= ", ";

                                             }

                                             $lista .= $this->quoteSmart($row[$campo]);

                              }

                              return $lista;

               }

}

 

 

/**

* O objetivo desta classe eh apenas permitir a diferenciacao (e o tratamento independente) de erros vindos do banco de dados.

*/

class SqlBDException extends Exception {

 

}

 

?>