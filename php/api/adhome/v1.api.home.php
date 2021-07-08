<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . "/php/control/goods.php";
require_once $root . "/php/control/orders.php";
require_once $root . "/php/control/users.php";
require_once $root . '/php/model/format_mysqli_result.php';
require_once $root . '/php/model/responseJSON.php';
// goodsCount()countOrder()sumMoeny()

class HomeDataApi
{
    
    public function goodsCount()
    {
        $goods = new Goods();
        $res = $goods->goodsCount();
        return resultToArray($res)[0]["count"];
    }
    public function ordersCount()
    {
        $order = new Orders();
        $res = $order->countOrder();
        return resultToArray($res)[0]["count"];
    }
    public function ordersMoney()
    {
        $order = new Orders();
        $res = $order->sumMoeny();
        return resultToArray($res)[0]["money"];
    }
    public function usersCount()
    {
        $user = new Users();
        $res = $user->coutUsers();
        // var_dump(resultToArray($res)[0]["num"]);
        return resultToArray($res)[0]["num"];
    }

    public function run()
    {
        $goodsSum = $this->goodsCount();
        $orderSum = $this->ordersCount();
        $moneySum = $this->ordersMoney();
        $userSum = $this->usersCount();
        $response = new responseJSON();
        if($goodsSum&& $orderSum && $moneySum && $userSum)
        {
            $data = [
                "goods"=>$goodsSum,
                "orders"=>$orderSum,
                "money"=>$moneySum,
                "users"=>$userSum
            ];
            $response->setResponse(200,"ok","主页数据获取成功",$data);
        }else{
            $response->defaultRespone();
        }
        return $response->getResponse();
    }
}

$me = new HomeDataApi();
echo $me->run();