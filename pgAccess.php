<?php
class pgAccess{
    var $host_name = "";
    var $user_name = "";
    var $password = "";
    var $db_name = "";
    var $conn_id = null;
    var $errno = 0;
    var $errstr = "";
    var $halt_on_error = true;
    var $query_pieces = [];
    var $result_id = null;
    var $num_rows = 0;
    var $row = [];

    function connect(){
        $this -> errno = 0;
        $this -> errstr = "";
        if($this -> conn_id == null){
            $this -> conn_id = @pg_connect("host= $this->host_name user= $this->user_name password= $this->password dbname= $this->db_name");
            if(!is_bool($this -> conn_id)){
                $this -> errno = -1;
                return ($this -> conn_id);
            }
            else{
                $this -> errno = PGSQL_CONNECTION_BAD;
                $this -> errstr = @pg_last_error();
                $this -> error("Не удаётся подключиться к серверу");
                return (FALSE);
            }
        }
    }

    function disconnect(){
        if($this -> conn_id != null){
            pg_close($this -> conn_id);
            $this -> conn_id = null;
        }
    }

    function error($msg){
        if(!$this -> halt_on_error)
            return;
        $msg .= "\n";
        die(nl2br(htmlspecialchars($msg)));
    }

    function issue_query($arg = ""){
        if($arg == "")
            $arg = [];
        if(is_bool($this -> connect()))
            return (FALSE);
        if(pg_connection_busy($this -> conn_id)){
            $this -> error("В данный момент выполняется предыдущий запрос");
            return (FALSE);
        }

        if(is_string($arg))
            $query_str = $arg;
        elseif (is_array($arg)) {
            if(count($arg) != count($this -> query_pieces) - 1){
                $this-> errno = -1;
                $this-> errstr = "Невозможно выполнить запрос: Неверное количество заполнителей";
                $this-> error($this-> errstr);
                return (FALSE);
            }
            $query_str = $query_pieces[0];
            for($i = 0; $i < count($arg); $i++)
                $query_str .= $this-> sql_quote($arg[$i]). $this-> query_pieces[$i + 1];
        }
        else{
            $this-> errno = -1;
            $this-> errstr = "Невозможно выполнить запрос: Неизвестный тип аргумента";
            $this-> error($this-> errstr);
            return (FALSE);
        }
        pg_send_query($this -> conn_id, htmlspecialchars($query_str));
        $this -> result_id = pg_get_result($this -> conn_id);
        $this -> num_rows = 0;
        $this -> errstr = pg_result_error($this -> result_id);
        if($this -> errstr != ""){
            $this -> error("Проверьте, указали ли вы имя БД при обращении к отношению.");
            $this -> error("Не удалось выполнить запрос: ".$query_str.". В процессе выполнения возникла ошибка ".$this -> errstr);
            return (FALSE);
        }
        $this -> num_rows = pg_affected_rows($this -> result_id);
        return $this -> result_id;
    }

    function fetch_array(){
        $this -> row = pg_fetch_array($this -> result_id);
        $this -> errstr = pg_result_error($this -> result_id);
        if($this -> errstr != ""){
            $this -> error("fetch error");
            return (FALSE);
        }
        if(is_array($this -> row))
            return $this -> row;
        $this -> free_result();
        return (FALSE);
    }

    function free_result(){
        if(!is_bool($this -> result_id))
            pg_free_result($this -> result_id);
        $this -> result_id = null;
        return (TRUE);
    }

    function sql_quote($str){
        if(!isset($str))
            return ("NULL");
        return (pg_escape_literal($str));
    }

    function prepare_query($query){
        $this -> query_pieces =explode("?", $query);
        return (TRUE);
    }
}
?>