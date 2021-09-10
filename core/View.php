<?php namespace K_MVC;
function read($file)
{
    $file = str_replace(".","\\",$file);
    $myfile = fopen("app\\view\\$file.html", "r") or die("không tìm thấy file '$file'");
    if(filesize("app\\view\\$file.html")>0)
    {
        $result = fread($myfile,filesize("app\\view\\$file.html"));
        fclose($myfile);
        return $result;
    }
    return "null";
    
}
function write($result)
{
    $path = "tmp/_view_tmp.php";
    $myfile = fopen($path, "w");
    fwrite($myfile, $result);
    fclose($myfile);
    return $path;
}

function section($data,$function)
{
    $da = explode("@$function",$data);

    foreach ($da as $key => $value) {
        if($value!='' && $key!=0)
        {
            $a = trim(explode("@end$function",$value)[0]);
            $sl = 0;
            for ($i=0; $i < strlen($a); $i++) { 
                if($a[$i] == '(')
                {
                    $sl++;
                }
                if($a[$i] == ')')
                {
                    $sl--;
                }
                if($sl == 0)
                {
                    $dat[substr($a,1,$i-1)] = trim(substr($a.' ',$i+1,-1));
                    break;
                }
            }

        }
    }
    return $dat ?? [];
}

function view($file,$obj = [])
{

    //Bước 1: đọc file html dưới dạng text;
        $data = trim(read($file));
    //bước 2: thây đổi các thuộc tính cần thây đổi
        if(strpos($data,"@extend")!==false)
        {
            //sử dụng kế thừa
            $array = section($data,'extend');
            $data_extend = read(array_key_first($array));
            foreach(section($data,'copy') as $key => $value)
            {
                $data_extend = str_replace("@paste($key)",$value,$data_extend);
            }
            $data = $data_extend;
        }
        $a  = section($data,'import') ;
        $data1 = $data."";

        foreach ($a as $key => $value) {
           $value = read($key);
           $data1 = str_replace("@import($key)",$value,$data1);
           
        }
        $data = $data1;
        
        $data = str_replace("{{","<?php print_r(",$data);
        $data = str_replace("}}",");?>",$data);


        $a  = section($data,'foreach') ;
        $data1 = $data."";
        foreach ($a as $key => $value) {
           $value = "<?php foreach($key){ ?>";
           $data1 = str_replace("@foreach($key)",$value,$data1);
           
        }
        $data = str_replace("@endforeach","<?php } ?>",$data1);






        $a  = section($data,'for') ;
        $data1 = $data."";

        foreach ($a as $key => $value) {
           $value = "<?php for($key){ ?>";
           $data1 = str_replace("@for($key)",$value,$data1);
           
        }
        $data = str_replace("@endfor","<?php } ?>",$data1);
        
        
        $a  = section($data,'if') ;
        $data1 = $data."";

        foreach ($a as $key => $value) {
           $value = "<?php if($key){ ?>";
           $data1 = str_replace("@if($key)",$value,$data1);   
        }
        $data = str_replace("@else","<?php }else{ ?>",$data1);

        $a  = section($data,'elseif') ;
        $data1 = $data."";

        foreach ($a as $key => $value) {
           $value = "<?php }elseif($key){ ?>";
           $data1 = str_replace("@elseif($key)",$value,$data1);
           
        }

        $data = str_replace("@endif","<?php } ?>",$data1);
        $a  = section($data,'while') ;
        $data1 = $data."";

        foreach ($a as $key => $value) {
           $value = "<?php while($key){ ?>";
           $data1 = str_replace("@while($key)",$value,$data1);
           
        }
        $data = str_replace("@endwhile","<?php } ?>",$data1);
        
        $data = str_replace("@break","<?php break; ?>",$data);   
        $data = str_replace("@continute","<?php continute; ?>",$data);   
        if($obj != [])
        {
            $var = '';
            foreach($obj as $name=>$value);
            {
                $var.= ' $'.$name.' = $obj["'.$name.'"]; ';
            }
            $data = "<?php $var ?>\n".$data;  
        }
    //bước 3: bước 3 luu file ở tmp dưới duôi .php
        $path = write($data);
    //bước 4: require_one file vào hàm;
        require_once($path);
    // //bước 5: xóa file ở thư mục tmp;
        unlink($path);
        //var_dump($data);
        return true;
}
