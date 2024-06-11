<?php
namespace Libs;
class App{
    public function __construct()
    {
      
$url=!empty($_GET['url']) ? $_GET['url']:"User";
$arrayUrl=explode("/",$url);

$controller=$arrayUrl[0];
$methode="index";
$params="";


if(!empty($arrayUrl[0])){
    $controller=$arrayUrl[0];
}

if(!empty($arrayUrl[1])){
    if($arrayUrl[1] !=""){
        $methode=$arrayUrl[1];
    }
}

if(!empty($arrayUrl[2])){
    if($arrayUrl[2] !=""){
         $params=array_slice($arrayUrl, 2);
    }
}



$myControllers=CONTROLLERS.$controller.'.php';
if(file_exists($myControllers)){
  require_once $myControllers;
   $myControllers=new $controller();

   if(method_exists($controller,$methode)){
    if($params){
        $myControllers->{$methode}(...$params);
    }else{
        $myControllers->{$methode}();
    }
   
   }else{
    require_once("controllers/Errors.php");
   }

}else{
 
     require_once("controllers/Errors.php");
     
}

    }
}

