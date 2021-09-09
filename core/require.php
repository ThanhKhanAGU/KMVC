<?php
require_once('core/connect.php');

require_once('core/Model.php');
require_once('core/view.php');
require_once('core/Controller.php');

foreach(glob('app/model/*') as $path)
{
    require_once($path);
}
foreach(glob('app/controller/*') as $path)
{
    require_once($path);
}
require_once('core/Route.php');

require_once('tmp/error/404.php');
