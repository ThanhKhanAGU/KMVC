<?php
require_once('connect.php');
class Table
{
    public static $script;
    public static function execute()
    {
        foreach (self::$script as $k => $item) {

            if (!connect::exec($item->sql()))
                die("Lỗi khi thêm bản: $k \n $item->sql()");
        }
        echo "\e[32mTạo Database thành công!\e[39m";
    }
    public static function reset()
    {
        $database_name = connect::get()['DATABASE'];
        $sql = "SELECT table_name FROM information_schema.tables
        WHERE table_schema = '$database_name'";
        $a = connect::exec($sql);
        while ($row = $a->fetch_assoc()) {
            $row = $row['table_name'];
            connect::exec("DROP TABLE `$row`");
        }
        echo "\e[32mReset Database thành công!\e[39m";
    }
    private $head = '';
    private $sql = '';
    private $foot = '';
    public function sql()
    {
        return $this->head . $this->sql . $this->foot;
    }
    public function __construct($name_database)
    {

        $this->head =
            "CREATE TABLE IF NOT EXISTS `$name_database` ( 
        `id` bigint(20) AUTO_INCREMENT";
        $this->foot = ",
        `time_create` datetime DEFAULT NULL,
        `time_edit` datetime DEFAULT NULL,
        PRIMARY KEY (`id`) 
        )ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        if ($name_database === 'user') {
            $this->foot = ',
            UNIQUE KEY(`username`)' . $this->foot;
        }
        self::$script[$name_database] = $this;
    }
    public function string($name, $size = 50, $default = '')
    {
        $this->sql .= ",
        `$name` nvarchar($size) DEFAULT '$default'";
    }
    public function text($name, $size = 2, $default = '')
    {
        $type[1] = "tinytext";
        $type[2] = "text";
        $type[3] = "mediumtext";
        $type[4] = "longtext";
        if ($size > 0 && $size < 6) {
            $this->sql .= ",
            `$name` $type[$size] DEFAULT N'$default'";
        } else die("sai kích thước");
    }
    public function int($name, $size = 4, $default = 0)
    {
        $type[1] = "tinyint";
        $type[2] = "smallint";
        $type[3] = "mediumint";
        $type[4] = "int";
        $type[5] = "bigint";
        if ($size > 0 && $size < 6) {
            $this->sql .= ",
            `$name` $type[$size] DEFAULT $default";
        } else die("sai kích thước");
    }
    public function id_r($name)
    {
        $this->sql .= ",
            `$name` bigint";
    }
    public function float($name, $default = 0)
    {
        $this->sql .= ",
            `$name` float DEFAULT  $default";
    }
    public function double($name, $default = 0)
    {
        $this->sql .= ",
        `$name` dounble DEFAULT  $default";
    }
    public function bit($name)
    {
        $this->sql .= ",
        `$name` bit(1) DEFAULT 0";
    }
    public function date($name)
    {
        $this->sql .= ",
        `$name` date DEFAULT NULL";
    }
    public function datetime($name)
    {
        $this->sql .= ",
        `$name` datetime DEFAULT NULL";
    }
    public function time($name)
    {
        $this->sql .= ",
        `$name` time DEFAULT NULL";
    }
}

foreach (glob('database/*.php') as $name) {
    require_once($name);
}
