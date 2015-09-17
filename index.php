<?
header("Content-type: text/html; charset=UTF-8");
define ("APP_DIR", "app/");
define ("INC_DIR", "vendor/optimit/");
define ("ENGINE_DIR", INC_DIR . "engine/src/");
define ("DATA_DIR", ".data/");
define ("LOGS_DIR", ".logs/");
define ("DO_SYSLOG", true);
define ("SYSLOG", LOGS_DIR . "/app.".date("Y-m-d").".log.txt");

require APP_DIR . "require.php";

if ( DEV_MODE ){
    error_reporting(E_ALL);
    ini_set("display_errors",1);
};

if ( defined("DO_DB_MIGRATE") && DO_DB_MIGRATE){
    return;
}else{
    include ENGINE_DIR . "engine.php";
};
