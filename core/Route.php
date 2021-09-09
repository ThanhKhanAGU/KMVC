<?php 
class Route{
    static public $get;
    static public $post;

    static public function get($_url,$func)
    {
        self::$get[] = [$_url,$func];
    }
    static public function post($_url,$func)
    {
        self::$get[] = [$_url,$func];
    }
}

foreach (glob('router/*') as $value) {
    require_once($value);    
}

function get_link($_url)
{
    $_path = $_url ?? '/';
    $_path = explode("/", $_path);
    foreach($_path as $i){
        if( $i !== '' ) 
        {
            $path[] = $i;
        }
    }   
    return $path ?? [];
}

function checklink($url1,$url2)
{
    $ex1 = get_link($url1);
    $ex2 = get_link($url2[0]);

    if(count($ex1) == count($ex2))
    {
        foreach($ex2 as $key=>$k1)
        {

            if( ($pos1 = strpos($k1,'{'))!==false && ($pos2 = strpos( $k1,'}'))!==false )
            {
               $value[substr($k1,$pos1+1,$pos2 - $pos1 -1)] = $ex1[$key];
            }elseif($ex1[$key] !== $k1)
            {
                return false;
            }
            
        } 
    } 
    else return false; 
    return [$url2[1], $value??[]];
}

if(isset($_SERVER['PATH_INFO']))
{
    $path_info = $_SERVER['PATH_INFO'];
}else
{
    $path_info = '/';
}

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
    foreach(Route::$get??[] as $path)
    {
        if(($data = checklink($path_info,$path))!==false)
        {
            if(gettype($data[0]) === 'string')
            {     
                     
                $func = explode('@',$data[0]);
                if(count($func)!=2) die("Khởi tạo route ko Đúng");
                
                $func[0]="K_MVC\\$func[0]Controller";
                if(!isset($data[1]))
                {
                    $a = new $func[0]();
                    $a->{$func[1]}();

                }else
                {
                    $a = new $func[0]();
                    //var_dump($func[0]);
                    call_user_func_array(array($a,$func[1]), $data[1]);
                }
            }
            else
            {
                
                call_user_func_array($data[0],$data[1]);
            }
            die();
        }
    }
}
else
{
    foreach(Route::$post??[] as $path)
    {
        if(($data = checklink($path_info,$path))!==false)
        {
            $value =$data[0];
            if(gettype($data[0]) === 'string')
            {
                $value = $data[1];
                $func = explode('@',$data[0]);
                if(count($func)!=2) die("Khởi tạo route ko Đúng");
                
                $func[0]="K_MVC\\$func[0]Controller";
                if(!isset($value))
                {
                    $a = new $func[0]();
                    $a->{$func[1]}();

                }else
                {
                    $a = new $func[0]();
                    call_user_func_array(array($a,$func[1]), $value);
                }
                
            }
            else
            {
                call_user_func_array($data[0],$data[1]);
            }
            die();
        }
    }
}
