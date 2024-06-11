<?php

use Libs\Controllers;
class Errors extends Controllers{
    public function __construct(){
       parent::__construct();
    }

    public function index()
    {
        $data=[
            'title'=>'Home',
        ];

       // $this->view->render($this,"errors/index",$data);

    }
   public function notFound()
    {
          $data=[
        'title'=>'Home',
    ];

        //$this->view->render($this,"errors/index",$data);
    }
  
}

 $notFound = new Errors();
 $notFound->notFound();