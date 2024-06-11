<?php
use Libs\Controllers;
class Home extends Controllers{
    public function __construct(){
       parent::__construct();
    }

    public function index()
    {

      
        $data=[
            'title'=>'Home',
        ];

        echo "hola";
        
        

    }

  /*==============================================
        GUADAR USUARIO EN LA BASE DE DATO
    ================================================*/
    function store(){

    }
    /*==============================================
        EXTRAER  USUARIO POR ID
    ================================================*/
    function edit(){
        
    }
  
    /*==============================================
        ACTUALIZAR USUARIOS
    ================================================*/
    function update(){

    }
    /*==============================================
        ELIMINAR USUARIO
    ================================================*/
    function delete(){

    }
}