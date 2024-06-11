<?php
namespace Libs;
class Load{
   public function __construct()
   {

    spl_autoload_register(function($class){
        if(file_exists(CONTROLLERS.$class.".php")){
            require_once CONTROLLERS.$class.".php";
        }
    });
    
   }
}