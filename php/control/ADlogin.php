<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root .'/php/model/DB.php';
class ADlogin
{

    /**
     * 验证验证码输入是否正确
     *
     * @return bool
     */
    public function checkcode()
    {
        
        $res=false;
        if(isset($_POST["captcha"]))
            if(strtolower($_POST["captcha"])==strtolower($_SESSION["captcha"]))
                $res=true;
        return $res;  //返回验证状态
    }

    /**
     * 用户登录操作
     *
     * @return void
     */
    public function login()
    {
        $res = false;
        if(isset($_POST["adaccout"])&&isset($_POST["adpsw"]))
        {   
            // 获取登录数据
            $name=$_POST["adaccout"];
            $psw=$_POST["adpsw"];
            //链接数据库
            $mydb=new DB_connect();
            $con = $mydb->connect();
            //执行sql查询 账号密码
            $sql="select admin_id,isaccess as permit,type from admins where name='{$name}' and psw='{$psw}' ";
            $results=mysqli_query($con,$sql);
            if($results)
                $row = mysqli_fetch_assoc($results);
            
            if($row['permit'])
            {
                //如果用户验证通过 把id、用户名、账号权限 写入session
                $_SESSION["adid"]=$row['admin_id'];
                $_SESSION["loginpass"]=$name;
                $_SESSION["role"]=$row['type'];

                $res=true;
            }
            else
            {
                $res=false;
            }
            //关闭数据库
            $mydb->close($con);
        }
        return $res; //返回登录状态
    }
    /**
     * 注销登录
     *
     * @return bool
     */
    public function logout()
    {
        $res=false;
        unset($_SESSION["loginpass"]);
        if(!isset($_SESSION["loginpass"]))
            $res=true;
        return $res; //返回注销状态 
    }
}


/*
//1、连接数据库
$link = mysql_connect($db_info['db_host'].':'.$db_info['db_port'],$db_info['db_user'],$db_info['db_pwd']);
if (! $link ) {
    die( 'Could not connect: '.mysql_error());
}
//echo  'Connected successfully' ;
//2、选择数据库
mysql_select_db( $db_info['db_name']) or die ( 'Can\'t use shop: ' . mysql_error());
//2.2 设置数据库连接所采用的字符编码
mysql_set_charset($db_info['db_charset']);
*/