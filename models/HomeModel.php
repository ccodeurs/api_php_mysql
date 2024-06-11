<?php

use Libs\Models;


class HomeModel extends Models{

    public function __construct()
    {
       parent::__construct();
       $this->db->connect();
    }

    public function get()
    {
       echo "get data from model";
    }


}