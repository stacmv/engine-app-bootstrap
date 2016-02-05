<?
require_once "vendor/autoload.php";

if ( !defined("ENGINE_DIR") ) die("Engine dir is not defined.");
if ( !defined("APP_DIR") ) die("App dir is not defined.");

$_SITE = array();
$CFG = array();
require_once APP_DIR . "settings/version.php";
require_once APP_DIR . "settings/define.php";
require_once APP_DIR . "settings/config.php";

spl_autoload_register(function ($class_name){$class_file =  APP_DIR . "classes/" . str_replace("\\", DIRECTORY_SEPARATOR , $class_name) . ".class.php"; if (file_exists($class_file)){ require_once $class_file; }});

// Base dir
$CFG["URL"]["base"] = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]); if (substr($CFG["URL"]["base"],-1)!="/") $CFG["URL"]["base"] .="/"; 
$CFG["URL"]["root"] = dirname($_SERVER["PHP_SELF"]); if (substr($CFG["URL"]["root"],-1)!="/") $CFG["URL"]["root"] .="/";



if (strpos($CFG["URL"]["base"], "http://localhost/") === 0){
    define("DEV_MODE", true);
    $sub_domain = $default_site;
}else{
    $sub_domain = strtok($_SERVER["HTTP_HOST"],".");
    if ( ! $sub_domain ) $sub_domain = $default_site;
    
    if ($sub_domain == "dev"){
        define("DEV_MODE", true);
        $sub_domain = $default_site;
    }else{
        define("DEV_MODE", false); 
    }
};

if (is_dir(SITES_DIR . $sub_domain)){
    define("SITE_DIR", SITES_DIR . $sub_domain . "/");
}else{
    define("SITE_DIR", APP_DIR);
}


// Engine functions
$engine_functions = array();
$tmp = glob(ENGINE_DIR . "functions/*.php");
foreach($tmp as $file_name) $engine_functions[ basename($file_name,".php") ] = $file_name;
unset($tmp, $file_name);


// Application functions
$app_functions = array();
$tmp = glob(APP_DIR . "functions/*.php");
foreach($tmp as $file_name) $app_functions[ basename($file_name,".php") ] = $file_name;
unset($tmp, $file_name);

// Site functions
$site_functions = array();
if (SITES_DIR != APP_DIR){
    $tmp = glob(SITE_DIR  . "functions/*.php");
    foreach($tmp as $file_name) $site_functions[ basename($file_name,".php") ] = $file_name;
    unset($tmp, $file_name);
};


// Determine wich functions to load
$functions_to_load = array_merge($engine_functions, $app_functions, $site_functions);


// Load functions
foreach($functions_to_load as $code=>$file_name){
    require_once $file_name;
}
require_once ENGINE_DIR . "default_functions.php";


// Site configuration
$CFG_ini = parse_ini_file( cfg_get_filename("settings", "settings.ini", ENGINE_SCOPE_ALL), true);
if ($CFG_ini == false) die("Code CFG INI");
$CFG = array_merge_recursive($CFG, $CFG_ini);

//
 
if (function_exists("get_site")){
    $_SITE = get_site($sub_domain);
}else{
    $_SITE = null;
};

// Logging level
if (DEV_MODE){
    glog_log_level("DEBUG");
}else{
    glog_log_level("INFO");
}