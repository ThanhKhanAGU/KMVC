<?php namespace K_MVC;


class userController extends Controller
{
    public function regis($request)
    {
        if(user::regis($request))
        {
            echo "đã thêm thành công";
        }
    }
    public function get_login()
    {
          if(!user::check())
             view('home');
          else var_dump($_COOKIE);
    }
    public function post_login($request)
    {
        var_dump(user::login($request->username,$request->password));
    }
}
