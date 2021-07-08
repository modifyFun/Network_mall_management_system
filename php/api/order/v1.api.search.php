<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . "/php/control/orders.php";
require_once $root . '/php/model/responseJSON.php';
require_once $root . '/php/model/format_mysqli_result.php';
class  SearchOrdersApi
{
    private $myorder;
    private $response;
    function __construct()
    {
        $this->myorder = new Orders();
        $this->response = new responseJSON();
    }

    public function  byUserId()
    {
        if(isset($_GET["search"]))
        {
            $res = $this->myorder->searchByUserId($_GET["search"]);
            $data = resultToArray($res); //mysqli_result 转换为数组
            if (!isset($data["isFormat"])) //判断是否转换成功
                $this->response->setResponse(200, "OK", "订单查询成功", $data); //设置JSON数据
            else
                $this->response->setResponse(400, "fail", "订单查询失败", $data);
        }
        else
        {
                $this->response->defaultRespone();
        }
        return $this->response->getResponse();
    }

    public function  byOrdersId()
    {
        
        if(isset($_GET["search"]))
        {
            $res = $this->myorder->searchByOrderId($_GET["search"]);
            $data = resultToArray($res); //mysqli_result 转换为数组
            if (!isset($data["isFormat"])) //判断是否转换成功
                $this->response->setResponse(200, "OK", "订单查询成功", $data); //设置JSON数据
            else
                $this->response->setResponse(400, "fail", "订单查询失败", $data);
        }
        else
        {
                $this->response->defaultRespone();
        }
        return $this->response->getResponse();
    }

    public function  byOrderState()
    {

        // $getArr = [
        //     'startPage',
        //     'pageSize',
        //     'search'
        // ];
        // //设置limit参数
        // if (getIsSet($getArr)["status"]) {
        //     $arr = [
        //         'start' => $_GET["startPage"] * $_GET["pageSize"],
        //         'pageSize' => $_GET["pageSize"]
        //     ];
            if(!isset($_GET["search"]))
            {
                $this->response->defaultRespone();
                return $this->response->getResponse();
            }
            $res = $this->myorder->searchByOrderState($_GET["search"]);
            $data = resultToArray($res); //mysqli_result 转换为数组
            $coutRes=$this->myorder->countOrder(); //获取订单列表大小
            $size = resultToArray($coutRes); //取得结果
            if (!isset($data["isFormat"])) //判断是否转换成功
                $this->response->setResponse(200, "OK", "订单查询成功", $data); //设置JSON数据
            else
                $this->response->setResponse(400, "fail", "订单查询失败", $data);
        
        
        return $this->response->getResponse();
    }

    
    public function run()
    {
        $data="";
        if(isset($_GET["type"]))
        {
            switch($_GET["type"])
            {
                case 1:
                    $data=$this->byOrdersId();
                break;
                case 2:
                    $data=$this->byUserId();
                break;
                case 3:
                    $data=$this->byOrderState();
                break;
                default:
                    $this->response->defaultRespone();
                    $data=$this->response->getResponse();
            }
        }
        else
        {
            $this->response->defaultRespone();
            $data=$this->response->getResponse();
        }
        return $data;
    }
}

$me = new SearchOrdersApi();
echo $me->run();

?>
