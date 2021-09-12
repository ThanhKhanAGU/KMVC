<?php
$__url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];
define('__URL__',$__url);
require_once('core/connect.php');
require_once('core/Model.php');
require_once('core/view.php');
require_once('core/Controller.php');
foreach(glob('app/model/*') as $path)
{require_once($path);}
if(file_exists("core/auth/user.php"))
require_once("core/auth/user.php");
if(file_exists('core/auth/user.php')) 
foreach(glob('app/controller/*') as $path)
{require_once($path);}
require_once('core/Route.php');
require_once('tmp/error/404.php');