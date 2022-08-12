<?php

class db{
    private $dbHost = 'localhost';
    private $dbUser = 'hostinjo_finper';
    private $dbPass = 'FinPer.2022';
    private $dbName = 'hostinjo_finper';

    //conexión

    public function conectionDB(){
        $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName;";
        $dbConnection = new PDO($mysqlConnect,$this->dbUser,$this->dbPass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbConnection->exec("SET CHARACTER SET utf8");
        return $dbConnection;
    }
}