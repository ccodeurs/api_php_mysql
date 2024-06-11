<?php
namespace Libs;

class Controllers{
  public function __construct()
  {
  $this->LoadModel();
  }

  public function LoadModel()
  {
    $model=get_class($this)."Model";
    $path=MODELS.$model.".php";
    if(file_exists($path)){
      require_once $path;

      $this->model=new $model();


    }
  }

}

