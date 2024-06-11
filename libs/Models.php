<?php

namespace Libs;

use Libs\Database;



class Models{
public function __construct()
{
 //  $this->db= new Database();
    Databases::init(SEVERNAME, USERNAME,PASS, DBNAME);
    Databases::connect();

}
    
}

