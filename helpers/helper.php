<?php
use Libs\Database;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//jwt
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


function dep($value)
{
  echo "<pre>";
  print_r($value);
  echo "</pre>";
}

function BaseUrl()
{
  return BASEURL;
}


function check($table, $column, $value)
{

  $db = new Database();
  $result = "";
  $check = $db->connect()->prepare("SELECT * FROM $table WHERE $column=:name");
  $check->bindParam(":name", $value);
  $check->execute();
  $res = $check->fetch(PDO::FETCH_ASSOC);
  return $res;
}

/*-----------------------------------------------------------
      autorization token
-----------------------------------------------------------*/
function   Autorization(array $data){

  if(empty($data["Authorization"])){
      $code=400;
      $response=array("status"=>false,"msg"=>"TOKEN REQUERIDO");
    JsonResponse($response,$code);
    die();
  }else{

    $uthorization=$data["Authorization"];
    $headerToken=explode(" ",$uthorization);

    if($headerToken[0] !="Bearer"){
      $code=400;
      $response=array("status"=>false,"msg"=>"NO AUTORIZADO");
      JsonResponse($response,$code);
      die();
    }else{
    

    try{
      $token=  $headerToken[1];
      $JWT = new JwtHandler();
      $decode= $JWT->verifyToken($token);
    }catch(ExpiredException  $e){

      //echo $e->getMessage();
      $code=400;
      $response=array("status"=>false,"msg"=> $e->getMessage());
      JsonResponse($response,$code);
      die();
    }
      
    }



  }


}//end

/*-----------------------------------------------------------
      FUNCTION PARAR LIMPIAR CAMPOS  
-----------------------------------------------------------*/
function strClean($strCadena){
    $string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], $strCadena);
    $string = trim($string); //Elimina espacios en blanco al inicio y al final
    $string = stripslashes($string); // Elimina las \ invertidas
    $string = str_ireplace("<script>","",$string);
    $string = str_ireplace("</script>","",$string);
    $string = str_ireplace("<script src>","",$string);
    $string = str_ireplace("<script type=>","",$string);
    $string = str_ireplace("SELECT * FROM","",$string);
    $string = str_ireplace("DELETE FROM","",$string);
    $string = str_ireplace("INSERT INTO","",$string);
    $string = str_ireplace("SELECT COUNT(*) FROM","",$string);
    $string = str_ireplace("DROP TABLE","",$string);
    $string = str_ireplace("OR '1'='1","",$string);
    $string = str_ireplace('OR "1"="1"',"",$string);
    $string = str_ireplace('OR ´1´=´1´',"",$string);
    $string = str_ireplace("is NULL; --","",$string);
    $string = str_ireplace("is NULL; --","",$string);
    $string = str_ireplace("LIKE '","",$string);
    $string = str_ireplace('LIKE "',"",$string);
    $string = str_ireplace("LIKE ´","",$string);
    $string = str_ireplace("OR 'a'='a","",$string);
    $string = str_ireplace('OR "a"="a',"",$string);
    $string = str_ireplace("OR ´a´=´a","",$string);
    $string = str_ireplace("OR ´a´=´a","",$string);
    $string = str_ireplace("--","",$string);
    $string = str_ireplace("^","",$string);
    $string = str_ireplace("[","",$string);
    $string = str_ireplace("]","",$string);
    $string = str_ireplace("==","",$string);
    return $string;
}

# ========================================================================================
# =      JSON RESPONSE
# ========================================================================================
function JsonResponse(array $arrayData,int $code){
    if(is_array($arrayData)){
        header("HTTP/1.1 ", $code);
        header("Content-type: application/json");
        echo json_encode($arrayData,true);
    }
}//end


/*-----------------------------------------------------------
      FUNCTION PARAR GENERAR
-----------------------------------------------------------*/

function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}//end


/*-----------------------------------------------------------
      FUNCTION PARAR ENCRYPTAR
-----------------------------------------------------------*/

function encryptID($id) {
  $key = KEY; // Reemplaza esto con tu clave de encriptación
  $method = METHOD; // Método de cifrado, puedes elegir otro si lo deseas

  $encrypted = openssl_encrypt($id, $method, $key);
  return base64_encode($encrypted);
}//


/*-----------------------------------------------------------
      FUNCTION PARAR DESINCRIPTAR
-----------------------------------------------------------*/
function decryptID($ID) {
  $key = KEY; // Reemplaza esto con tu clave de encriptación
  $method =METHOD; // Método de cifrado, debe ser el mismo utilizado para cifrar

  $encrypted = base64_decode($ID);
  $decrypted = openssl_decrypt($encrypted, $method, $key);
  return $decrypted;
}///END


/*-----------------------------------------------------------
     FUNCTION PARA FORMATEAR FECHA 
-----------------------------------------------------------*/
 function transformarFechaParaDB($fecha) {
    $timestamp = strtotime($fecha);
    if ($timestamp === false) {
        return false; // Fecha no válida
    }
    $fechaParaDB = date('d/m/Y', $timestamp);
    return $fechaParaDB;
}//END


/*-----------------------------------------------------------
      FUNCTION PARA ENVIAR EMAIL  
-----------------------------------------------------------*/
function send_mail($data,$template){
    $to      = $data['email'];
    $title    = $data['subjet'];

    // Para enviar un correo HTML, debe establecerse la cabecera Content-type
    $header  = 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

    // Cabeceras adicionales
    //$cabeceras .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
    $header .= 'From: mini-framwork <miniframwork-php@gmail.com>' . "\r\n";
    //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
    //$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
    ob_start();
    require_once("views/mails/".$template.".php");
    $message=ob_get_clean();

    $send=mail($para, $titulo, $mensaje, $header);
    return $send;
}//END

/*-----------------------------------------------------------
       FUNCTION PARA ENVIAR EMAIL EN LOCAL 
-----------------------------------------------------------*/
function send_mail_local($data,$template){
$mail = new PHPMailer(true);

  ob_start();
  require_once("views/mails/".$template.".php");
  $message=ob_get_clean();

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'example@example.com';                     //SMTP username
    $mail->Password   = '';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('example@example', 'example');
    $mail->addAddress($data['email'], $data['name']);     //Add a recipient             //Name is optional
      /* $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');*/

    //Attachments
    /*$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); */   //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $data["asunto"];
    $mail->Body    = $message;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    return true;

} catch (Exception $e) {
    die($e->getMessage());
}



}













