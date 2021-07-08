<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . "/php/control/orders.php";
require_once $root . '/php/model/responseJSON.php';
require_once $root . '/php/model/checkListEmpty.php';
require_once $root . '/php/model/format_mysqli_result.php';
class  OrdersListApi
{
    private $myorder;
    private $response;
    function __construct()
    {
        $this->myorder = new Orders();
        $this->response = new responseJSON();
    }
    public function orderList()
    {
        // $getArr = [
        //     'startPage',
        //     'pageSize'
        // ];
        // //设置limit参数
        // if (getIsSet($getArr)["status"]) {
        //     $arr = [
        //         'start' => $_GET["startPage"] * $_GET["pageSize"],
        //         'pageSize' => $_GET["pageSize"]
        //     ];
        // }
        $res = $this->myorder->orderList();
        $data = resultToArray($res); //mysqli_result 转换为数组 并追加入 data数组

        if (!isset($data["isFormat"])) //判断是否转换成功
        {
            $coutRes=$this->myorder->countOrder(); //获取订单列表大小
            $size = resultToArray($coutRes); //取得结果
            
            $this->response->setResponse2(200, "OK", "successful",$size[0]['count'], $data); //设置JSON数据
        }    
        else
            $this->response->setResponse2(400, "fail", "商品列表获取失败",0,$data);
        return $this->response->getResponse2();
    }

    public function run()
    {
        return $this->orderList();
    }
}

$me = new OrdersListApi();
echo $me->run();