<?php
use Libs\DataBases;
use Libs\Models;


class UserModel extends Models{
   private $id;
   private $first_name;
   private $last_name;
   private $email;
   private $password;
   private $rol;
   private $status;
   private $image;
      private $table="users";

    public function __construct()
    {
       parent::__construct();
      // $this->db= new Database();
    
    }

/*-----------------------------------------------------------
        ETRAER TODOS LOS USUARIOS
-----------------------------------------------------------*/
    function Index(){
      try {
          $sql = "SELECT * FROM users WHERE status !=0";
          $user= Databases::all( $sql);
          return $user;
      } catch (Exception $e) {
         die("error " . $e->getMessage());
      }
    } //END

/*-----------------------------------------------------------
       ETRAER TODOS LOS USUARIOS
-----------------------------------------------------------*/
    function getById(int $id){
      try {
         $this->id=$id;
         $user= Databases::whereId("users","id", $this->id);
         return $user;
      } catch (Exception $e) {
         die("error " . $e->getMessage());
      }
    }//END

/*-----------------------------------------------------------
       VERIFICAR SI EL EMAIL EXISTE EN DB
-----------------------------------------------------------*/
   function ShowByEmail($email)
   {
      $this->email=$email;
      try {
          $res= Databases::whereId("users","email", $this->email);
         return $res;
         
      } catch (Exception $e) {
         die("hubo un error " . $e->getMessage() );
      }
   }//END

/*-----------------------------------------------------------
       INSERTAR USUARIO EN LA BASE DE DATO
-----------------------------------------------------------*/
    function Insert($first_name,$last_name,$email,$password,$image=null,$rol,$status)
    {
    $this->first_name=$first_name;
    $this->last_name=$last_name;
    $this->email=$email;
    $this->password=$password;
    $this->rol=$rol;
    $this->status=$status;
    $this->image=$image;

      try {
         $sql="INSERT INTO users (first_name,last_name,email,password,image,rol,status)
         VALUES(:first_name,:last_name,:email,:password,:image,:rol,:status)";
         $data=[
            ':first_name'=>$this->first_name,
            ':last_name'=>$this->last_name,
            ':email'=>$this->email,
            ':password'=>$this->password,
            ':image'=>$this->image,
            ':rol'=>$this->rol,
            ':status'=>$this->status
         ];
          $user= Databases::insert($sql,$data);
          return $user;

         
      } catch (Exception $e) {
        die("error " . $e->getMessage()); 
      }
       
    }//END

/*-----------------------------------------------------------
         INSERTAR USUARIO EN LA BASE DE DATO
-----------------------------------------------------------*/
    function Update($id,$first_name,$last_name,$email,$rol,$status)
    {
        $this->id=$id;
        $this->first_name=$first_name;
        $this->last_name=$last_name;
        $this->email=$email;
        $this->rol=$rol;
        $this->status=$status;

      try {

             $sql="UPDATE   $this->table SET first_name=:first_name,last_name=:last_name,email=:email,rol=:rol,status=:status WHERE id=:id";
             $data=[
                "id"=>$this->id,
                ':first_name'=>$this->first_name,
                ':last_name'=>$this->last_name,
                ':email'=>$this->email,
                ':rol'=>$this->rol,
                ':status'=>$this->status
             ];
 
          $user= Databases::update($sql,$data);
          return $user;

         
      } catch (Exception $e) {
        die("error " . $e->getMessage()); 
      }
       
    }//END


/*-----------------------------------------------------------
         ACTUALIZAR  USUARIO EN LA BASE DE DATO
-----------------------------------------------------------*/
    function UpdatePsaaword($id,$password)
    {
        try {
            $this->id=$id;
            $this->password=$password;
             $data=[
                "id"=>$this->id,
                ':password'=> password_hash( $this->password,PASSWORD_DEFAULT )
             ];
            $sql="UPDATE $this->table SET password =:password WHERE id=:id";
             $user= Databases::update($sql,$data);
            return $user;

        } catch (Exception $e) {
            die("error " . $e->getMessage()); 
        }
        
    }//EEND

/*-----------------------------------------------------------
         ACTUALIZAR IMAGEN DEL USUARIO EN LA BASE DE DATO
-----------------------------------------------------------*/
    function UpdateImage($id,$image)
    {
        try {
            $this->id=$id;
            $this->image=$image;
            $data=[":id"=>$this->id,":image"=>$image];

            $sql="UPDATE   $this->table SET image =:image WHERE id = :id";
            $user= Databases::update( $sql,$data);
            return $user;


        } catch (Exception $e) {
            die("error " . $e->getMessage());  
        }

     
    }//END

/*-----------------------------------------------------------
         VERIFICAR SI EL USUARIO YA EXISTE EN LA BASE DE DATO
-----------------------------------------------------------*/
    function checkExisteUpdate($email,$id)
   {
      $this->email=$email;
      $this->id=$id;

      try {
         $sql="SELECT * FROM $this->table WHERE email = ? AND id !=?";
         $res= Databases::get($sql,[$this->email,$this->id]);
         return $res;
         
      } catch (Exception $e) {
         die("hubo un error " . $e->getMessage() );
      }
   }//END


/*-----------------------------------------------------------
        ELIMINAR USUARIO YA EXISTE EN LA BASE DE DATO
-----------------------------------------------------------*/
 function Delete($id)
    {
       $this->id=$id;
        try {
            $sql=" DELETE FROM $this->table WHERE id=:id";
            $data=array(":id"=>$this->id);
            $user= Databases::softDelete($sql, $data);
          return $user;
         
      } catch (Exception $e) {
         die("error " . $e->getMessage()); 
      }
    }
/*-----------------------------------------------------------
        ELIMINAR USUARIO YA EXISTE EN LA BASE DE DATO
-----------------------------------------------------------*/    
    function SoftDelete($id)
    {
       $this->id=$id;
        try {
            $sql=" UPDATE $this->table SET status=0 WHERE id=:id";
            $data=array(":id"=>$this->id);
            $user= Databases::softDelete($sql, $data);
          return $user;
         
      } catch (Exception $e) {
         die("error " . $e->getMessage()); 
      }
    }

/*-----------------------------------------------------------
        ACTIVAR O DESACTIVAR USUARIO
-----------------------------------------------------------*/    
    function Acivte($id){
        $this->id=$id;
        try {
            $sql=" UPDATE $this->table SET status = CASE WHEN status=1 THEN 2 ELSE 1 END WHERE id=:id";
            $data=array(":id"=>$this->id);
            $user= Databases::update($sql, $data);
          return $user;
         
      } catch (Exception $e) {
         die("error " . $e->getMessage()); 
      }
    }//END

/*-----------------------------------------------------------
       BUSCAR USUARIO
-----------------------------------------------------------*/  
    function Search($search)
    {
      try {
         $sql="SELECT * FROM users WHERE first_name Like :search OR last_name LIKE :search OR email LIKE :search";
         $data=array(":search"=> '%'.$search.'%');
          $user= Databases::searchData($sql, $data);
          return $user;
         
      } catch (Exception $e) {
         die("error "  . $e->getMessage()) ;
      }
       
    }//END

/*-----------------------------------------------------------
       INICIAR SESSION
-----------------------------------------------------------*/  
function Login($email,$password)
{
    $this->email=$email;
    $this->password=$password;
    try {

        $sql="SELECT * FROM $this->table WHERE email = ?";
        $res=Databases::get($sql,[$this->email]);
        return $res;

    } catch (Exception $e) {
          die("hubo un error " . $e->getMessage() );
    }
      
}

}//END CLASS