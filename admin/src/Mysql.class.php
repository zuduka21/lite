<?php

class Mysql
{
    private $mysql;

    public function __construct ($login, $password, $database)
    {
        //die();
        date_default_timezone_set ('Europe/Moscow');

        $this->mysql = mysqli_connect("localhost", $login, $password);
        $this->mysql->set_charset('utf8mb4');
        $this->mysql->select_db($database);
        $this->mysql->query ("SET SESSION sql_mode = ''");
        
        //$this->markBrokenSessions();
    }
    
    public function close() {
        return mysqli_close($this->mysql);
    }
    
    public function getLastID() {
        return $this->mysql->insert_id;
    }
    
    public function getMysql()
    {
        return $this->mysql;
    }
    
    public function getQuery($sql) {
        $t = microtime (true);
        $res = $this->mysql->query ($sql);
        //echo $sql."\n\n";
        $ret = array();
        
        if ($res) {
            while ($item = @$res->fetch_object()) {
                $ret[] = $item;
            }
        } else {
            error_log ("Mysql :: " . $this->mysql->error);
        }
        $t = microtime (true) - $t;
        if ($t > 1) file_put_contents("slow_sql.log", $sql . "\n\n" . $t . "\n----------------\n", FILE_APPEND | LOCK_EX);
        return $ret;
    }

    public function runQuery($sql) {
        $t = microtime (true);
        $res = $this->mysql->query ($sql);
        $t = microtime (true) - $t;
        if (!$res) {
            error_log ("Mysql :: " . $this->mysql->error);
        }
        //if ($t > 1) file_put_contents("slow_sql.log", $sql . "\n\n" . $t . "\n----------------\n", FILE_APPEND | LOCK_EX);
        return;
    }
    
    public function escapeString($string) {
        return mysqli_real_escape_string ($this->mysql, $string);
    }

    public function getConfig($key = false) {
        $config = array();

        $res = $this->getQuery("SELECT * FROM `config`");
        foreach ($res as $item) {
            $config[$item->key] = $item->value;
        }
        
        $ret = (object) $config;
        if ($key !== false) {
            $ret = isset ($config[$key]) ? $config[$key] : null;
        }
        return $ret;
    }
    
    public function setConfig($key, $value) {
        if ($key == '') return;
        $key = mysqli_real_escape_string ($this->mysql, $key);
        $value = mysqli_real_escape_string ($this->mysql, $value);
        $this->runQuery("INSERT INTO `config` SET `key`='{$key}', `value`='{$value}'");
        $this->runQuery("UPDATE `config` SET `value`='{$value}' WHERE `key`='{$key}'");
    }

    public function log($event, $message) {
        $date = date("Y-m-d H:i:s");
        
        $event = $this->escapeString($event);
        $message = $this->escapeString($message);
        
        $this->runQuery("INSERT INTO `log_txt` SET `date`='{$date}', `event`='{$event}', `message`='{$message}'");
    }
}