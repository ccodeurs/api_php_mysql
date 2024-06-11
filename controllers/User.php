<?php
use Libs\Controllers;

class User extends Controllers{

    public $method;
    public $JWT;
    public function __construct(){
       parent::__construct();
       $this->method=$_SERVER['REQUEST_METHOD'];
     
      

    }
/*-----------------------------------------------------------
        ETRAER TODOS LOS USUARIOS
-----------------------------------------------------------*/
    public function index()
    {
       try{
        $response=[];
        if($this->method=="GET"){

  
            /*--------ruta protegida------------------------*/
             $header=getAllheaders();
             $header=Autorization( $header);
            /*---------------------------------------------*/
            //para dejar la ruta publica quita estas dos lineas


              $code=200;
                $response=array("status"=>true,"data"=>$this->model->Index());

        }else{
           $code=400;
           $response=array("status"=>false,"msg"=>"error en la respuesta " . $this->method);
        }
            JsonResponse($response,$code);
       }catch(Exception $e){
            $response=array("status"=>false,"msg"=> $e->getMessage());
            JsonResponse($response,400);
            die();
       }


       
    }//END

/*-----------------------------------------------------------
        ETRAER  USUARIO POR SU ID
-----------------------------------------------------------*/
    function show($id=null)
    {
        try{
        $response=[];
        if($this->method=="GET"){

            if(!isset($id) || $id==null){
            $code=400;
            $response=array("status"=>false,"msg"=>"USUARIO NO ENCONTRADO");
         
            }else{
              $code=200;
              $response=array("status"=>true,"data"=>$this->model->getById($id));  
            }

        }else{
           $code=400;
            $response=array("status"=>false,"msg"=>"error en la respuesta " . $this->method);
        }
        JsonResponse($response,$code);
       }catch(Exception $e){
        die(" error " . $e->getMessage());
       }

    }//END 

    
/*-----------------------------------------------------------
        GUARDAR  USUARIO
-----------------------------------------------------------*/
function store(){
    $response=[];

    try{
        if($this->method=="POST"){
            // Verificar si se envió el archivo de imagen correctamente
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadsDirectory = 'upload/img/users/';
            $newName=uniqid().$_FILES['image']['name'];
          
            $path = $uploadsDirectory.$newName;
            move_uploaded_file($_FILES['image']['tmp_name'], $path);
        } else {
            $path = null; 
        }
           

            if (empty($_POST['first_name'])) {
                $code=400;
                $response=array("status"=>false,"msg"=>"EL NOMBRE ES OBLIGATORIO");
               JsonResponse($response,$code);
               die();
            }
            if (empty($_POST['last_name'])) {
                $code=400;
                $response=array("status"=>false,"msg"=>"EL APELLIDO ES OBLIGATORIO");
               JsonResponse($response,$code);
                die();
            }
             if (empty($_POST['email'])) {
                $code=400;
                $response=array("status"=>false,"msg"=>"EL EMAIL ES OBLIGATORIO");
               JsonResponse($response,$code);
                die();
            }
              if(! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $code=400;
                $response=array("status"=>false,"msg"=>"EL FORMATO DEL EMAIL NO ES VALIDO");
               JsonResponse($response,$code);
                die();
            }
             if (empty($_POST['password'])) {
                $code=400;
                $response=array("status"=>false,"msg"=>"LA CONTRASEÑA ES OBLIGATORIO");
               JsonResponse($response,$code);
                die();
            }
             if (empty($_POST['rol'])) {
                $code=400;
                $response=array("status"=>false,"msg"=>"SELECCÒNA UN ROL POR FAVOR");
               JsonResponse($response,$code);
                die();
            }
            if (empty($_POST['status'])) {
                $code=400;
                $response=array("status"=>false,"msg"=>"SELECCÒNA ESTADO POR FAVOR");
               JsonResponse($response,$code);
                die();
            }
            $first_name= strtolower(strClean($_POST['first_name'])) ;
            $last_name= strtolower(strClean($_POST['last_name'])) ;
            $email= strtolower(strClean($_POST['email'])) ;
            $password=$_POST['password'];
            $rol= strtolower(strClean( $_POST['rol']));
            $status= strtolower(strClean($_POST['status'])) ;
            $password_hash=password_hash( $password,PASSWORD_DEFAULT);

            $exist=$this->model->ShowByEmail($email);
            if($exist){
                $code=200;
                $response=array("status"=>false,"msg"=>"USUARIO  YA ESTA REGISTRADO ");
                JsonResponse($response,$code);
                return;
            }

           
         
            $user=$this->model->Insert($first_name,$last_name,$email, $password_hash, $path , $rol, $status );
            if($user){
                $code=200;
                $response=array("status"=>true,"msg"=>"USUARIO GUARDADO CON EXITO","InsertId"=>$user);
                JsonResponse($response,$code);
            }
          
            
        }else{
            $code=400;
            $response=array("status"=>false,"msg"=>"error en la respuesta ALGO falla " . $this->method);
               JsonResponse($response,$code);
        }
 

    }catch(Exception $e){
        die("error " . $e->getMessage());
    }
}//END

/*-----------------------------------------------------------
         EXTRAER  USUARIO POR ID
-----------------------------------------------------------*/
function active($id){
    try {
        if($this->method=="POST"){
           $active=$this->model->Acivte($id);
        }else{
            $code=400;
            $response=array("status"=>false,"msg"=>"error en la respuesta " . $this->method);
        }
    } catch (Exception $e) {
        die("error " . $e->getMessage());
    }
}

/*-----------------------------------------------------------
        ACTUALIZAR  USUARIO 
-----------------------------------------------------------*/
function update($id=null)
{
   if($_SERVER['REQUEST_METHOD'] == "POST"  && isset($_POST['_method']) && $_POST['_method'] == 'PUT'){

    if( empty($id) ||  !is_numeric($id)){
          $code=400;
            $response=array("status"=>false,"msg"=>"PARAMETRO INVALIDO");
           JsonResponse($response,$code);
           die();
    }



        $first_name = isset($_POST['first_name']) ? strtolower(strClean($_POST['first_name'])) : null;
        $last_name = isset($_POST['last_name']) ? strtolower(strClean($_POST['last_name'])) : null;
        $email = isset($_POST['email']) ? strtolower(strClean($_POST['email'])) : null;
        $password = isset($_POST['password']) ? strClean($_POST['password']) : null;
        $rol = isset($_POST['rol']) ? strtolower(strClean($_POST['rol'])) : null;
        $status = isset($_POST['status']) ? strtolower(strClean($_POST['status'])) : null;


          if (empty(  $first_name)) {
                    $code=400;
                    $response=array("status"=>false,"msg"=>"EL NOMBRE ES OBLIGATORIO AMIGO");
                   JsonResponse($response,$code);
                   die();
                }




                if (empty( $last_name)) {
                    $code=400;
                    $response=array("status"=>false,"msg"=>"EL APELLIDO ES OBLIGATORIO");
                   JsonResponse($response,$code);
                    die();
                }
                 if (empty( $email)) {
                    $code=400;
                    $response=array("status"=>false,"msg"=>"EL EMAIL ES OBLIGATORIO");
                   JsonResponse($response,$code);
                    die();
                }
                  if(! filter_var( $email, FILTER_VALIDATE_EMAIL)){
                    $code=400;
                    $response=array("status"=>false,"msg"=>"EL FORMATO DEL EMAIL NO ES VALIDO");
                   JsonResponse($response,$code);
                    die();
                }

                if(!empty($password)){
                    $this->model->UpdatePsaaword($id,$password);
                     //$password_hash= !isset($password) ? password_hash( $password,PASSWORD_DEFAULT) : "";
                   
                 }
             
                 if (empty($rol)) {
                    $code=400;
                    $response=array("status"=>false,"msg"=>"SELECCÒNA UN ROL POR FAVOR");
                   JsonResponse($response,$code);
                    die();
                }
                if (empty($status)) {
                    $code=400;
                    $response=array("status"=>false,"msg"=>"SELECCÒNA ESTADO POR FAVOR");
                   JsonResponse($response,$code);
                    die();
                }


                    $exist=$this->model->checkExisteUpdate($email,$id);
                    if(!empty( $exist)){
                     $code=400;
                   $response=array("status"=>false,"msg"=>"USUARIO YA EXISTE");
                   JsonResponse($response,$code);
                    die();
                }{
                    
              
               

                $updated=false;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $this->update_image($id);
                    $user=$this->model->Update($id,$first_name,$last_name,$email, $rol, $status );
                    $updated=true;
                }else{

                 $user=$this->model->Update($id,$first_name,$last_name,$email,$rol, $status );
                    $updated=true;
                }

               if($updated){
                    $code=200;
                    $response=array("status"=>true,"msg"=>"USUARIO ACTUALIZADO CON EXITO",$user);
                    JsonResponse($response,$code);
               }
            }   
   }else{
    $code=400;
    $response=array("status"=>false,"msg"=>"error en la respuesta " . $this->method);
    JsonResponse($response,$code);
   }
         
}//END 

/*-----------------------------------------------------------
                 ACTUALIZAR IMAGEN
-----------------------------------------------------------*/
function update_image($id)
{
    
   try { 
       if($this->method=="POST"){

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

            $nombreimg=$_FILES['image']["name"];
            $nombre_temporal=$_FILES['image']["tmp_name"];
            $nombre_final=date("m-d-d")."-". date("H-i-s"). "-".$nombreimg;

            $tipoImagen = $_FILES["image"]['type'];
            $permitidos = array('image/jpeg','image/jpg', 'image/png');
           

            //verificar si formato es autorizado
            if(!in_array($tipoImagen,$permitidos)){
                 $code=400;
                $response=array("status"=>false,"msg"=>"EL TIPO DE IMAGEN DEBE SER JPEG,JPG,PNG");
                JsonResponse($response,$code); 
                die();
               }

            //validar el tamaño de la imagen 
            $tamañoMaximo = 2 * 1024 * 1024; // 2MB en bytes
            if ($_FILES["image"]['size'] > $tamañoMaximo) {

                 $code=400;
                $response=array("status"=>false,"msg"=>"EL TAMAÑO DE LA IMAGEN EXCEDE EL LIMITE PERMITIDO DE 2MB.");
                JsonResponse($response,$code); 
                die();
            }

            //preparar carpeta donde almacenamos las imagenes
            $uploadsDirectory = 'upload/img/users/';
            $newName=uniqid().$nombreimg;
            $path = $uploadsDirectory.$newName;


            //verificamos si la imagen anterior si existe lo eliminamos para almacenar la nueva imagen
            $image=$this->model->getById($id);
            $old_image=$image["image"];


                $updated=false;

                if(file_exists($old_image)){
                    unlink($old_image);
                   $this->model->UpdateImage($id,$path);
                      $updated=true;

                 }else{
                  $this->model->UpdateImage($id,$path);
                    $updated=true;
                }
             
                
                if($updated){
                        move_uploaded_file($nombre_temporal,$path);
                }

            }else{
                $code=400;
                $response=array("status"=>false,"msg"=>"NO HAS SELECCÒNADO NINGUN IMAGEN");
                JsonResponse($response,$code); 
                die();
            }

           }else{

            $code=400;
            $response=array("status"=>false,"msg"=>"error en la respuesta " . $this->method);
            JsonResponse($response,$code);
        }


    } catch (Exception $e) {
      die(" error " . $e->getMessage());   
    }
}//END


/*-----------------------------------------------------------
        ELIMINAR USUARIO
-----------------------------------------------------------*/
function delete($id=null,$type_delete="normal"){
    try { 
        /*=============================================
        (soft_delete)=  no elimina el dato en base de dato solo poner el estado a 0 y conserve las
        imagenes asociado al usuario en carpeta para el futuro se nececita recuperar el usuario

        (normal) = te permite eliminar en la base de dato y en carpeta ojo no se puede recupera nunca asi que cuidado
        =============================================*/

    if($this->method=="POST"){

        
            /*--------ruta protegida------------------------*/
            $header=getAllheaders();
            $header=Autorization( $header);
           /*---------------------------------------------*/
           //para dejar la ruta publica quita estas dos lineas



        if(empty($id) || !is_numeric($id)){
            $code=200;
            $response=array("status"=>true,"msg"=>"PARAMETRO INVALIDO" );
            JsonResponse($response,$code);
            die();
        }

        switch($type_delete){

            case  "soft_delete" :

                $user=$this->model->SoftDelete($id);
               if ($user) {
                  $code=400;
                  $response=array("status"=>true,"msg"=>"USUARIO ELIMINADO CON EXITO");
                  JsonResponse($response,$code); 
                  die(); 

               }
            break;

            case  "normal" :
            $user=$this->model->getById($id);
            $old_image='';
            if (!empty( $user)) {
                 $old_image=$user["image"];
            }else{
               $code=400;
              $response=array("status"=>true,"msg"=>"USUARIO CON ID $id NO EXISTE");
              JsonResponse($response,$code); 
              die();  
            }
           
              $is_deleted=false;
            if(file_exists( $old_image)){

                if(unlink( $old_image)){
                      $use=$this->model->Delete($id);
                      $is_deleted=true;
                    }
            }else{
                $use=$this->model->Delete($id);
                $is_deleted=true;
            }

            if ($is_deleted) {
              $code=400;
              $response=array("status"=>true,"msg"=>"USUARIO ELIMINADO CON EXITO");
              JsonResponse($response,$code); 
              die(); 

            }
 


            break;
        }

       



       }
  } catch (Exception $e) {
      die(" error " . $e->getMessage());   
  }     
}//END

/*-----------------------------------------------------------
       BUSCAR USUARIO
-----------------------------------------------------------*/
function search($search)
{
    $response=[];
    if($this->method=="GET")
    {
        if (!empty($search)) 
        {
            $user=$this->model->Search($search);
            $code=200;
            $response=array("status"=>true,"data"=> $user );
            JsonResponse($response,$code);
        }

    } 
}//END


/*-----------------------------------------------------------
     INICIAR SESSION
-----------------------------------------------------------*/
function login()
{
    if($this->method=="POST")
    {
        $_POST=json_decode(file_get_contents("php://input"),true);
        $email=trim( strtolower($_POST['email']) );
        $password=trim(  $_POST['password']);
        $login=$this->model->Login($email,$password);
        $user=$login[0];


        if(!empty($user))
        {

            if( !empty( $password) || password_verify($password,$user['password']))
            {
               
                if($user['status'] !=1)
                {

                    $code=400;
                    $response=array("status"=>false,"msg"=>"NO PUEDES ACCEDER PORQUE TU CUENTA  ESTA DESACTIVADO POR FAVOR CONTACTA EL ADMINISTRADOR PARA ACTIVARLO" );
                    JsonResponse($response,$code);
                    return;
                }else{
                    $ID=$user["id"];
                    $EMAIL=$user["email"];
                    $dataArray=[
                        "id"=>$ID,
                        "email"=>$EMAIL
                    ];
                    $JWT = new JwtHandler();
                    $token= $JWT->generateToken( $dataArray);
                    $code=200;
                    $response=array("status"=>true,"user"=>$user,"token"=> $token);
                     JsonResponse($response,$code);
                }


            }else{
                $code=400;
                $response=array("status"=>false,"msg"=>"LA CONTRASEÑA ES INCORRECTO INTENTE DE NUEVO" );
                JsonResponse($response,$code);
                return;  
            }
           
        }else{
            $code=400;
            $response=array("status"=>false,"msg"=>"EL EMAIL ES INCORRECTO INTENTE DE NUEVO" );
            JsonResponse($response,$code);
            return;
            
        }
  
    }
}







  
}//END CLASS