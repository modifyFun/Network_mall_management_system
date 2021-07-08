<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . "/php/control/orders.php";
require_once $root . '/php/model/responseJSON.php';
require_once $root . '/php/model/checkListEmpty.php';
require_once $root . '/php/model/format_mysqli_result.php';

class  OrdersDetailApi
{
    private $myorder;
    private $response;
    function __construct()
    {
        $this->myorder = new Orders();
        $this->response = new responseJSON();
    }
    public function orderDetail()
    {
        $res = $this->myorder->orderDetail();
        $data = resultToArray($res); //mysqli_result 转换为数组 并追加入 data数组
        if (!isset($data["isFormat"])) //判断是否转换成功
        {
            $this->response->setResponse(200, "OK", "successful", $data); //设置JSON数据
        }    
        else
            $this->response->setResponse(400, "fail", "订单详情获取失败",$data);
        return $this->response->getResponse();
    }
    public function run()
    {
        return $this->orderDetail();
    }
}

$me = new OrdersDetailApi();
echo $me->run();