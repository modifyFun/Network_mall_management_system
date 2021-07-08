<?php
//数据库链接处理类
class DB_connect{
    private $db_info;
    function __construct() {
       $this->db_info=array(
           'db_host' => '127.0.0.1',
           'db_user' => 'root',
           'db_pwd' => 'root',
           'db_name' => 'myshop',
           'db_charset'=> 'utf8',
           'db_port' => '3306'
        );
    }
    /**
     * 链接数据库
     *
     * @return object
     */
    public function connect()
    {
        $connect = @mysqli_connect
        (
            $this->db_info['db_host'],
            $this->db_info['db_user'],
            $this->db_info['db_pwd'],
            $this->db_info['db_name'],
            $this->db_info['db_port']
        );

        if(!$connect)
        {
            //die( 'Could not connect: '.@mysqli_error($connect));
            return null;
        }
        return $connect;
    }

    /**
     * 关闭数据库链接
     *
     * @param [object] $con
     * @return bool
     */
    public function close($con)
    {
        return mysqli_close($con);
    }

    public function query($sql)
    {
        $con = $this->connect();
        $results=mysqli_query($con,$sql);
        $this->close($con);
        if($results)
            return $results;
        return false;
    }
}

// $me = new DB_connect();
// var_dump($me->connect()) ;
?>