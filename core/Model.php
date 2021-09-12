<?php
namespace K_MVC;

class dataTable{
    private $sql = '';
    private $table = '';
    public function __construct($table,$sql = NULL)
    {
        $this->sql = "SELECT * FROM $table";
        $this->table = $table;
        if($sql!=null) $this->sql = $sql;
    }
    public function all()
   {
       $data = \connect::database($this->sql);
       $datatable = new dataTable($this->table,$this->sql);
       $i=1;
       if($data->num_rows > 0)
       {
            while ($row = $data->fetch_assoc()) {
                $tenclass = "K_MVC\\$this->table";
                $r = new $tenclass();
                foreach ($row as $key => $value) {
                    $r->$key = $value;
                }
                $datatable->$i = $r;
                $i++;
            }
            return $datatable; 
       }
       return [];
       
   }

    public function where($data, $value1 = null, $value2 = null)
   {
       $and = ' and';
       if(!strpos($this->sql,'WHERE'))
       {
           $and = ' WHERE';
       }
       if(gettype($data) == 'string' && $value1!= null && $value2!= null)
       {
           $this->sql.=$and." `$data` $value1 N'$value2'";
       }
       elseif(gettype($data) == 'string' && $value1!= null &&$value2 == null)
       {
           $this->sql.=$and." `$data` = N'$value1'";
       }
       elseif(gettype($data) == 'array' && $value1 == null &&$value2 == null)
       {
           $sql = '';
           foreach($data as $key=>$item)
           {
               if(count($item)==3)
               {                  
                   $sql.= " `$item[0]` $item[1] N'$item[2]'";
                   if(count($data)-1 != $key) $sql.=' and';
               }
           }
           if($sql!='') $this->sql.=$and.$sql;
       }
       return $this->all();
          
   }
    public function orWhere($data, $value1 = null, $value2 = null)
   {
       if(strpos($this->sql,'WHERE')!=false)
       {
           
           $and = ' or';
           if(gettype($data) == 'string' && $value1!= null && $value2!= null)
           {
               $this->sql.=$and." `$data` $value1 N'$value2'";
           }
           elseif(gettype($data) == 'string' && $value1!= null &&$value2 == null)
           {
               $this->sql.=$and." `$data` = N'$value1'";
           }
           elseif(gettype($data) == 'array' && $value1 == null &&$value2 == null)
           {
               $sql = '';
               foreach($data as $key=>$item)
               {
                   if(count($item)==3)
                   {                  
                       $sql.= " `$item[0]` $item[1] N'$item[2]'";
                       if(count($data)-1 != $key) $sql.=' or';
                   }
               }
               if($sql!='') $this->sql.= $and.$sql;
           }
           return $this->all();
       }  
       return $this;
   }
    public function orderBy($column)
   {
       if(!strpos($this->sql,'ORDER BY')) $order = ' ORDER BY';
       else $order = ' ,';
       if(gettype($column)=='string'){
           $co[] = $column;
           $column = $co;
       }

       foreach($column as $k=>$c)
       {
           if($k!=count($column)-1)
           {
               $order.=" $c,";
           }else{
               $order.=" $c";
           }
       }
       $this->sql.=$order;
       return $this->all();
   }
    public function orderByDesc($column)
   {
       if(!strpos($this->sql,'ORDER BY')) $order = ' ORDER BY';
       else $order = ' ,';
       if(gettype($column)=='string'){
           $co[] = $column;
           $column = $co;
       }
       foreach($column as $k=>$c)
       {
           if($k!=count($column)-1)
           {
               $order.=" $c DESC,";
           }else{
               $order.=" $c DESC";
           }
       }
       $this->sql.=$order;
       return $this->all();
   } 
    public function limit($limit)
   {
       if(!strpos($this->sql,'LIMIT'))
           $this->sql.=" LIMIT $limit";
       else{
           $this->sql = explode($this->sql,'LIMIT')[0]." LIMIT $limit";
       }
       return $this->all();
   }
   public function first()
   {
        return ((array) $this)[1] ?? [];
   }
   public function select($obj)
   {
       if(gettype($obj)=="string")$obj = [$obj];
       $select = '';
       foreach($obj as $k => $i)
       {
           if($k != count($obj) - 1 )
           {
               $select.= " `$i`,";
           }
           else
           {
               $select.= " `$i`";
           }
       }
       $this->sql = "SELECT $select FROM ".explode('FROM',$this->sql)[1];
       return $this->all();
   }
}
class Model
{
    public function save()
    {
        date_default_timezone_set('asia/ho_chi_minh');
        if(isset($this->id))
        {
            $__this = explode('\\',get_class($this));
            $_sql = 'UPDATE `'.$__this[1].'` SET ';
            foreach( $this as $key => $value )
            {
                if($key!='id'&& $key!='table')
                {
                    
                    if(gettype($value)=="string")
                    {
                        $_sql.= "`$key`= N'$value', ";
                    }else
                    {
                        $_sql.= "`$key`='$value', ";
                    }
                }
            }

            $_sql.= "`time_edit` = '".date("Y/m/d H:i:s")."' WHERE `id` = $this->id";
            
            return \connect::database($_sql);
        }else
        {
            $__this = explode('\\',get_class($this));
            $_name = "INSERT INTO `".$__this[1].'` (';
            $_data = ') VALUES (';
            foreach( $this as $key => $value )
            {
               if($key != 'table')
               {
                    $_name.="`".$key.'`, ';
                    if(gettype($value)=="string")
                    {
                        $_data.="N'".$value."', ";
                    }else
                    {
                        $_data.="'".$value."', ";
                    }
               }
                
            }
            $_name.='`time_create`, `time_edit`'.
            $_data.="'".date("Y/m/d H:i:s")."','".date("Y/m/d H:i:s")."')";
            return \connect::database($_name);
        }
    }
    public function delete()
    {
        if(isset($this->id))
        {
            $__this = explode('\\',get_class($this));
            $_sql = "DELETE FROM `".$__this[1]."` WHERE `id` = $this->id";
            return \connect::database($_sql);
        }
        return false;
        
    }
    public static function all()
    {
        return (new dataTable(explode('\\',get_called_class())[1]))->all();
    }
    public static function where($data, $value1 = null, $value2 = null)
    {
        return (new dataTable(explode('\\',get_called_class())[1]))->where($data,$value1,$value2);
    }
    public static function find($id)
    {
        return (new dataTable(explode('\\',get_called_class())[1]))->where('id',$id)->first();
    }
}