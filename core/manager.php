<?php 
function _help()
{
    print_r(
        "
    \e[34m██╗  ██╗ \e[31m███╗   ███╗\e[35m██╗   ██╗ \e[93m██████╗
    \e[34m██║ ██╔╝ \e[31m████╗ ████║\e[35m██║   ██║\e[93m██╔════╝
    \e[34m█████╔╝  \e[31m██╔████╔██║\e[35m██║   ██║\e[93m██║     
    \e[34m██╔═██╗  \e[31m██║╚██╔╝██║\e[35m╚██╗ ██╔╝\e[93m██║     
    \e[34m██║  ██╗ \e[31m██║ ╚═╝ ██║ \e[35m╚████╔╝ \e[93m╚██████╗
    \e[34m╚═╝  ╚═╝ \e[31m╚═╝     ╚═╝  \e[35m╚═══╝   \e[93m╚═════╝                               
        ");
        echo "\e[39m KMVC framework 2021.\n\n";
        echo "\e[39m - Tác Giả: Trần Thanh Khan.\n";
        echo "\e[39m - Github : \e[4mhttps://github.com/thanhKhanAGU\e[24m\n";
        echo "\e[39m - Đại học: Đại học An Giang.\n";  
        echo "\e[39m - Lớp    : DH19TH2 \n\n";    
        echo "\e[39m Bảng Lệnh trong \e[34mK\e[31mM\e[35mV\e[33mC\e[0m Framework:\n";      
        echo "\e[39m    □ \e[33m-all              \e[90m<Tên Obj>   \e[39m- Tạo một đối tượng cho toàn bộ Project.\n";
        echo "\e[39m    □ \e[33m-mvc              \e[90m<Tên MVC>   \e[39m- Tạo ra một cấu trúc MVC.\n";
        echo "\e[39m    □ \e[33m-model            \e[90m<Tên Model> \e[39m- Tạo ra một class Model.\n";
        echo "\e[39m    □ \e[33m-view             \e[90m<Tên View>  \e[39m- Tạo ra một view ở pages.\n";
        echo "\e[39m    □ \e[33m-view-admin       \e[90m<Tên View>  \e[39m- Tạo ra một cấu trúc view ở Admin và Pages.\n";
        echo "\e[39m    □ \e[33m-controller       \e[90m<Tên Ctrl>  \e[39m- Tạo ra một class Controller.\n";
        echo "\e[39m    □ \e[33m-controller-route \e[90m<Tên Ctrl>  \e[39m- Tạo ra một class Controller và Các Route tương ứng.\n";
        echo "\e[39m    □ \e[33m-table            \e[90m<Tên bảng>  \e[39m- Tạo một bảng trong kịch bản của CSDL.\n";
        echo "\e[39m    □ \e[33m-add-data         \e[90m<Tên data>  \e[39m- Thêm dữ liệu vào trong CSDL.\n";
        echo "\e[39m    □ \e[33m-reset-db         \e[90m            \e[39m- Xóa toàn bộ CSDL.\n";
        echo "\e[39m    □ \e[33m-execute-db       \e[90m            \e[39m- Thực thi kịch bản để tạo ra CSDL.\n";        
}

function write($path,$name,$result)
{
    $path = "$path/$name";
    $myfile = fopen($path, "w");
    fwrite($myfile, $result);
    fclose($myfile);
    echo " - \e[32mĐã Tạo File $name Thành Công\e[39m\n";
}
function read()
{
    $file = 'router\\web.php';
    $myfile = fopen($file, "r");
    $result = fread($myfile,filesize($file));
    fclose($myfile);
    return $result; 
}
function create_model($name)
{
    $text = 
'<?php
namespace K_MVC;


class '.$name.' extends Model
{

}';

write('app\\model\\',"$name.php",$text);
die();
}
function create_database($name)
{
    $text = 
'<?php
#----------------------------------------------------------------------------
#----------------------         CÁC KIỂU DỮ LIỆU       ----------------------
# $table->string("tên",0->255) : kiểu chữ
# $table->text("tên",1->4)     : kiểu văn bản
# $table->int("tên",1->5)      : kiểu số nguyên
# $table->id_r("tên")          : kiểu id liên kết
# $table->float("tên")         : kiểu float
# $table->double("tên")        : kiểu double
# $table->bit("tên")           : kiểu true / false
# $table->date("tên")          : kiểu ngày (YYYY/MM/DD)
# $table->datetime("tên")      : kiểu thời gian và ngày (YYYY/MM/DD H:m:s)
# $table->time("tên")          : kiểu thời gian (H:m:s)
#------   Nhập Code   --------
$table = new Table("'.$name.'");';
    write('database',"_".time()."_$name.php",$text);
    $data = '
<?php
# thêm dữ liệu vào database
$data[] = [];


#thực thi thêm data vào bảng
foreach($data as $item)
{
    $dt = new '.$name.'();
    foreach($item as $key=>$value)
    {
        $dt[$key] = $value;
    }
    $dt->save();
}';
    write('database/data',"$name.php",$data);
    die();
}
function create_controller($name,$route = false)
{
    $f = '';
    if($route == true)
        $f = 
'public function sites()
    {
        #Code....
    }
    public function site($id)
    {
        #Code....
    }
    public function add_get()
    {
        #Code....
    }
    public function add_post($Request)
    {
        #Code....
    }
    public function edit_get($id)
    {
        #Code....
    }
    public function edit_post($Request)
    {
        #Code....
    }
    public function delete_get($id)
    {
        #Code....
    }';
    $text = 
'<?php namespace K_MVC;


class '.$name.'Controller extends Controller
{
    '.$f.'
}
';
write('app/controller/',"$name.php",$text);
    if($route == true)
    {
        $route = "//-----------------   Begin Router của '$name'   -----------------";
        $route.= "\nRoute::get('$name/sites','$name@sites');\n";
        $route.= "\nRoute::get('$name/site/{name}/{id}','$name@site');\n";
        $route.= "\nRoute::get('$name/add','$name@add_get');\n";
        $route.= "\nRoute::post('$name/add','$name@add_post');\n";
        $route.= "\nRoute::get('$name/edit/{id}','$name@edit_get');\n";
        $route.= "\nRoute::post('$name/edit','$name@edit_post');\n";
        $route.= "\nRoute::get('$name/delete/{id}','$name@delete_get');\n";  
        $route.= "//------------------   End Router của '$name'   ------------------";
        write('router/',"web.php",read().$route); 
    }
    die();
}


function create_view($name)
{
    $admin[] = 'add'; 
    $admin[] = 'delete';
    $admin[] = 'edit';
    $admin[] = 'list';
    $html = 
'@extend(admin/layout/main)

@copy(name)
    Đang là trang Admin <i>$$$</i> '.$name.'
@endcopy

@copy(content)
    <h1>Đang là trang Admin <i>$$$</i> <b>'.$name.'</b></h1>
@endcopy';
    foreach($admin as $item )
    {    
        write("app/view/admin/$name","$item.html",str_replace('$$$',$item,$html));
    }
    $html = 
'@extend(pages/layout/main)

@copy(name)
    Đang là trang Danh Sách '.$name.'
@endcopy

@copy(content)
    <h1>Đang là trang Danh Sách <b>'.$name.'</b></h1>
@endcopy';
    write("app/view/pages/$name","info_$name.html",$html);

    write("app/view/pages/$name","p_$name.html",str_replace('Danh Sách',"Chi Tiết",$html));

    die();
}
function create_view_page($name)
{
    $html = 
'@extend(pages/layout/main)

@copy(name)
    Đang là trang '.$name.'
@endcopy

@copy(content)
    <h1>Đang là trang <b>'.$name.'</b></h1>
@endcopy';

write("app/view/pages/","$name.html",$html);
die();
}


if($argc === 2)
{
    if($argv[1] === '-reset-db')
    {
        require_once('core/database.php');
        echo "Xóa Toàn Bộ cơ sở dữ liệu? ( DL Không thể phục hòi! ) (Y/N): ";
        if(strtoupper(readline()) === "Y")
        {
            Table::reset();
        }
        die();
       
    }
    if($argv[1] === '-execute-db')
    {
        require_once('core/database.php');
        echo "Tạo Mới CSDL? ( không ghi đè bản đã có ) (Y/N): ";
        if(strtoupper(readline()) === "Y")
        {
            Table::execute();
        }
        die();
    }
    _help();

}elseif($argc === 3)
{
    if($argv[1] === '-all')
    {
        foreach(glob("database/*.php") as $item)
        {
            if(strpos($item,"_$argv[2].php") !== false)
            {
                echo " - \e[41m Table đã tồn tại!\e[49m";
            }
            else
            {
                create_database($argv[2]);
            }    
        }
        if(file_exists("app\model\\$argv[2].php"))
        {
            echo " - \e[41m Model đã tồn tại!\e[49m";
        }
        else
        {
            create_model($argv[2]);
        }
        
        if(is_dir("app/view/admin/$argv[2]/")&&is_dir("app/view/pages/$argv[2]/"))
        {
            echo " - \e[41m View đã tồn tại!\e[49m";
        }else
        {
            mkdir("app/view/admin/$argv[2]/");
            mkdir("app/view/pages/$argv[2]/");
            create_view($argv[2]);
        }

        if(file_exists("app\controller\\$argv[2].php"))
        {
            echo " - \e[41m Controller đã tồn tại!\e[49m";
        }
        else
        {
            create_controller($argv[2],true);
        }
        die();
    }
    if($argv[1] === '-mvc')
    {
        if(file_exists("app\model\\$argv[2].php"))
        {
            echo " - \e[41m Model đã tồn tại!\e[49m";
        }
        else
        {
            create_model($argv[2]);
        }
        
        if(is_dir("app/view/admin/$argv[2]/")&&is_dir("app/view/pages/$argv[2]/"))
        {
            echo " - \e[41m View đã tồn tại!\e[49m";
        }else
        {
            mkdir("app/view/admin/$argv[2]/");
            mkdir("app/view/pages/$argv[2]/");
            create_view($argv[2]);
        }

        if(file_exists("app\controller\\$argv[2].php"))
        {
            echo " - \e[41m Controller đã tồn tại!\e[49m";
        }
        else
        {
            create_controller($argv[2],true);
        }
        die();
    }
    if($argv[1] === '-model')
    {
        if(file_exists("app\model\\$argv[2].php"))
        {
            echo " - \e[41m Model đã tồn tại!\e[49m";
        }
        else
        {
            create_model($argv[2]);
        }
        die();
    }
    if($argv[1] === '-view')
    {
        if(file_exists("app/view/pages/$argv[2].html"))
        {
            echo " - \e[41m View đã tồn tại!\e[49m";
        }else
        {
            create_view_page($argv[2]);
        }
        die();
    }
    if($argv[1] === '-view-admin')
    {
        if(is_dir("app/view/admin/$argv[2]/")&&is_dir("app/view/pages/$argv[2]/"))
        {
            echo " - \e[41m View đã tồn tại!\e[49m";
        }else
        {
            mkdir("app/view/admin/$argv[2]/");
            mkdir("app/view/pages/$argv[2]/");
            create_view($argv[2]);
        }
        die();
    }
    if($argv[1] === '-controller')
    {
        if(file_exists("app\controller\\$argv[2].php"))
        {
            echo " - \e[41m Controller đã tồn tại!\e[49m";
        }
        else
        {
            create_controller($argv[2]);
        }
        die();
    }
    if($argv[1] === '-controller-route')
    {
        if(file_exists("app\controller\\$argv[2].php"))
        {
            echo " - \e[41m Controller đã tồn tại!\e[49m";
        }
        else
        {
            create_controller($argv[2],true);
        }
        die();
    }
    if($argv[1] === '-table')
    {
        foreach(glob("database/*") as $item)
        {
            if(strpos($item,"_$argv[2].php") !== false)
            {
                echo " - \e[41m Table đã tồn tại!\e[49m";
                die();
            }  
        }
        create_database($argv[2]);
        die();
    }
    if($argv[1] === '-add-data')
    {
       if(file_exists("database/data/$argv[2].php"))
       {
           require_once("database/data/$argv[2].php");
           echo "\e[32mĐã Thêm CSDL Thành Công.\e[39m";
           die();
       }else
       {
            echo "\e[31mKhông tìm thấy dữ liệu.\e[39m";
       }
       die();
    }
    _help();
}else _help();
