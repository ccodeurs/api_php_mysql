<?php
class Validations{

# ========================================================================================
# =      METODO PARA VALIDA EMAIL     =
# ========================================================================================
public static function validateEmail($email,$msg){
    if(! filter_var($email, FILTER_VALIDATE_EMAIL)){
        $response=array('status'=>false,"msg"=>$msg);
         
        echo json_encode($response);
        exit;
    }
}
# ========================================================================================
# =      METODO PARA VALIDA STRING     =
# ========================================================================================
public static function validateString2($string,$msg){

  if(!preg_match("/^[a-zA-Z]+$/", $string)){
    $response=array('status'=>false,"msg"=>$msg);
        echo json_encode($response);
     exit;
  }
}
# ========================================================================================
# =      METODO PARA VALIDA LETRAS  2   =
# ========================================================================================
public static function validateString($string,$msg)
{
	$pattern = '/^[A-Za-z][A-Za-z0-9_ -]*[A-Za-z]?$/';
  if(!preg_match($pattern, $string)){
    $response=array('status'=>false,"msg"=>$msg);
        echo json_encode($response);
     exit;
  }
}
# ========================================================================================
# =      METODO PARA VALIDA NUMEROS  2   =
# ========================================================================================
public static function validateNumber($number,$msg){
	$pattern2 = "/^[0-9]+$/";
    if(!preg_match("/^[0-9]+$/",$number)){
        $response=array('status'=>false,"msg"=>$msg);
        echo json_encode($response);
     exit;
    }
}
# ========================================================================================
# =      METODO PARA VALIDA DNI  =
# ========================================================================================
public static function validateDni($string,$msg)
{
	$dniPattern = '/^[a-zA-Z][0-9]{7}[a-zA-Z]$/';
	$MESSAGE="";
  if(!preg_match($dniPattern, $string)){

  	
    $response=array('status'=>false,"msg"=>$msg);
        echo json_encode($response);
     exit;
  }
}
# ========================================================================================
# =      METODO PARA VALIDAR TELEFONO  =
# ========================================================================================
public static function validatePhone($string,$msg)
{
	$phonePattern = '/^\+\d{1,4}\s?\d{9}$/';
  if(!preg_match($phonePattern, $string)){

  	
    $response=array('status'=>false,"msg"=>$msg);
        echo json_encode($response);
     exit;
  }
}
# ========================================================================================
# =      METODO PARA VALIDAR PRECIO  =
# ========================================================================================
public static function validatePrice($string,$msg)
{
$decimalPricePattern = '/^\d+(\.\d{1,2})?$/';
  if(!preg_match($decimalPricePattern, $string)){
    $response=array('status'=>false,"msg"=>$msg);
        echo json_encode($response);
     exit;
  }
}
# ========================================================================================
# =      METODO PARA VALIDAR FECHA  =
# ========================================================================================
public static function validateDate($string,$msg)
{
$datePattern = '/^\d{4}-\d{2}-\d{2}$/';
  if(!preg_match($datePattern, $string)){
    $response=array('status'=>false,"msg"=>$msg);
        echo json_encode($response);
     exit;
  }
}












}





