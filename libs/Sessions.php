<?php

class Sessions {
public static function SetSession($session_name,$session_value) {
	$_SESSION[$session_name]=$session_value;
}

public static function getSession($session_name){
  return $_SESSION[$session_name];
}

public static function destroySession(){
   session_unset();
   session_destroy();
}

public static function closeSessions($name){
	unset($_SESSION[$name]);
}


}




