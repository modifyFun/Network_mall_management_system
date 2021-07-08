<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . "/php/control/goods.php";
require_once $root . '/php/model/responseJSON.php';
require_once $root . '/php/model/format_mysqli_result.php';

/**
 * 获取商品详情内容 api
 * 需要 get 参数
 */
class GoodDetailApi
{
    private $mygoods;
    private $response;
    function __construct()
    {
        $this->mygoods = new Goods();
        $this->response = new responseJSON();
    }
    /**
     * 根据 商品id 获取商品详情内容
     * 需要get参数 
     *  goods_id
     *
     * @return JSON
     */
    public function getDetailById()
    {
        if(isset($_GET["goods_id"]))
        {
            $res = $this->mygoods->getGoodsDetail($_GET["goods_id"]);
            $data = resultToArray($res); //mysqli_result 转换为数组
            if (!isset($data["isFormat"])) //判断是否转换成功
                $this->response->setResponse(200, "OK", "商品详情获取成功", $data); //设置JSON数据
            else
                $this->response->setResponse(400, "fail", "商品详情获取失败", $data);
        }
        else
        {
            $this->response->defaultRespone();
        }   
        return $this->response->getResponse();
    }

    /**
     * 入口函数
     *
     * @return JSON
     */
    public function run()
    {
        return $this->getDetailById();
    }
}

$me = new GoodDetailApi();
echo $me->run();