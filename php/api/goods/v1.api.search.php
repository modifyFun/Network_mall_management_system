<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root."/php/control/goods.php";
require_once $root .'/php/model/responseJSON.php';
require_once $root . '/php/model/format_mysqli_result.php';

/**
 * 搜索商品api
 * 需要 get参数
 *  "search" 查找条件
 *  "type" 查找类型
 */
class searchGoodsApi
{
    private $mygoods; //goods控制器
    private $response; //JSON

    function __construct()
    {
        $this->mygoods=new Goods();
        $this->response = new responseJSON();
    }
    /**
     * 根据ID 查询商品
     * 需要get参数
     *  "search" 商品id
     * @return void
     */
    public function byId()
    {
        if(isset($_GET["search"]))
        {
            $res = $this->mygoods->searchGoodsById($_GET["search"]); //执行根据id查询商品函数
           
            $data= resultToArray($res);//mysqli_result 转换为数组
            if(!isset($data["isFormat"]))//判断是否转换成功
                $this->response->setResponse(200,"OK","successful",$data);//设置JSON数据
            else
                $this->response->setResponse(400,"fail","查询失败",$data);
            return $this->response->getResponse();
        }
    }

    /**
     * 根据名称 查询商品
     * 需要get参数
     *  "search" 商品名称前部分
     * @return void
     */
    public function byName()
    {
        if(isset($_GET["search"]))
        {
            $res = $this->mygoods->searchGoodsByName($_GET["search"]); //执行根据名称查询商品函数
            $data= resultToArray($res);//mysqli_result 转换为数组
            if(!isset($data["isFormat"]))//判断是否转换成功
                $this->response->setResponse(200,"OK","successful",$data);//设置JSON数据
            else
                $this->response->setResponse(400,"fail","查询失败",$data);
            return $this->response->getResponse();
        }
    }
    /**
     * 根据类别 查询商品
     * 需要get参数
     *  "search"  类别id
     * @return void
     */
    public function byCategory()
    {
        if(isset($_GET["search"]))
        {
            $res = $this->mygoods->searchGoodsByCategory($_GET["search"]); //执行根据类别查询商品函数
            $data= resultToArray($res);//mysqli_result 转换为数组
            if(!isset($data["isFormat"]))//判断是否转换成功
                $this->response->setResponse(200,"OK","successful",$data);//设置JSON数据
            else
                $this->response->setResponse(400,"fail","查询失败",$data);
            return $this->response->getResponse();
        }
    }

    /**
     * 根据商品状态查询商品
     * 需要get参数
     *  "search" 商品状态
     * @return void
     */
    public function byState()
    {
        if(isset($_GET["search"]))
        {
            $res = $this->mygoods->searchGoodsByState($_GET["search"]); //执行根据商品状态查询商品函数
            $data= resultToArray($res);//mysqli_result 转换为数组
            if(!isset($data["isFormat"]))//判断是否转换成功
                $this->response->setResponse(200,"OK","successful",$data);//设置JSON数据
            else
                $this->response->setResponse(400,"fail","查询失败",$data);
            return $this->response->getResponse();
        }
    }
    
    /**
     * 入口函数
     * 需要get 参数
     * "type" 查询类别
     * @return void
     */
    public function run()
    {
        $data="";
        if(isset($_GET['type']))
        {
            switch($_GET['type'])
            {
                case 1:
                    $data = $this->byId();
                break;
                case 2:
                    $data = $this->byName();
                break;
                case 3:
                    $data = $this->byCategory();
                break;
                case 4:
                    $data = $this->byState();
                break;
            }
        }
        if (!$data) {
            //默认输出
            $this->response->defaultRespone();
            $data = $this->response->getResponse();
        }
        return $data;
    }
}

$me = new searchGoodsApi();
echo $me->run();
