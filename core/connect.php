<?php
class connect{
    public static $data = NULL;
    public static function get()
    {
        $file = fopen('database/.config','r') or die("File Không tồn tại");
        while(!feof($file)) {
            $line= fgets($file);
            if(trim($line)!='')
            {
                $line = explode('=',$line);
                $data[trim($line[0])] = trim($line[1]??'');
            }
        }
        fclose($file);
         return $data;
    }
    public static function database($sql)
    {
        header("Content-type: text/html; charset=utf-8");
        $d = connect::get();
        $con = new mysqli($d['HOSTNAME'],$d['USERNAME'], $d['PASSWORD'], $d['DATABASE']);
        mysqli_set_charset($con, 'UTF8');
        return $con->query($sql);
    }
    public static function exec($sql)
    {
       // header("Content-type: text/html; charset=utf-8");
        $d = connect::get();
        $con = new mysqli($d['HOSTNAME'],$d['USERNAME'], $d['PASSWORD'], $d['DATABASE']);
        mysqli_set_charset($con, 'UTF8');
        return $con->query($sql);
    }
}