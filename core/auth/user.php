<?php namespace K_MVC;
class user extends Model
{
    private static $u = NULL;
    public static $time = 1800;
    private static $check = NULL;
    public static function user()
    {
        if(self::$u == NULL)
        {
            self::$u = user::where('remember_login',$_COOKIE['__login__remember__CAfCWIr8VHpIpap4n'])->first();
        }
        return self::$u;
    }
    public static function Login(string $user, string $pass):bool
    {
        $pass = md5($pass);
        $sql = "SELECT * FROM `user` WHERE `username` = '$user' and `password` = '$pass'";
        $a = \connect::database($sql);
        if($a->num_rows > 0)
        {
            $row = $a->fetch_assoc();
            setcookie('__login__remember__CAfCWIr8VHpIpap4n', $row['remember_login'], time() + self::$time, "/");
            return true;
        }
        return false;
    }
    public function regis()
    {
        $this->password = md5($this->password);
        $this->remember_login = \connect::randum().time();
        if( count((array)self::where('username',$this->username))===0)
            return $this->save();
        else
            return -1;
    }
    public static function check()
    {
        if(self::$check==NULL)
        {
            if(isset($_COOKIE['__login__remember__CAfCWIr8VHpIpap4n']))
            {
                $data = self::where('remember_login',$_COOKIE['__login__remember__CAfCWIr8VHpIpap4n'])->first();
                self::$check = isset($data->remember_login);
            }
            else
                return false;
        }
        return self::$check;  
    }
    public static function logout()
    {
        if(self::check()) 
        {
            unset($_COOKIE['__login__remember__CAfCWIr8VHpIpap4n']);
            setcookie('__login__remember__CAfCWIr8VHpIpap4n', '', time() - 3600, '/');
        }
        self::$u = NULL;
        self::$check = NULL;
        
    }
    
}