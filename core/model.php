<?php


abstract class Model{
   protected $db;

    public function __construct(){
        $this->db = DB::getInstance();
        $this->db->connect();
    }
}