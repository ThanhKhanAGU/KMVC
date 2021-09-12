<?php namespace K_MVC;
require_once('core\Model.php');
require_once('core\connect.php');
require_once('core\auth\user.php');
# thêm dữ liệu vào database
$data = [
    [
        'username' => 'kmvc',
        'password' => ''
    ]
];


#thực thi thêm data vào bảng
foreach($data as $item)
{
    $dt = new user();
    foreach($item as $key=>$value)
    {
        $dt->$key = $value;
    }
    user::regis($dt);
}