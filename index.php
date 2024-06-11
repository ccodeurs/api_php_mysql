<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE,PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include __DIR__."/libs/Sessions.php";
include __DIR__."/vendor/autoload.php";
include __DIR__."/helpers/helper.php";
include __DIR__."/config/config.php";
include __DIR__."/libraries/JwtHandler.php";
include __DIR__."/libs/DataBases.php";
include __DIR__."/controllers/Validations.php";
use Libs\App;

$app=new App();


