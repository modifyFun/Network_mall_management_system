<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . "/php/control/orders.php";
require_once $root . '/php/model/responseJSON.php';
require_once $root . '/php/model/checkListEmpty.php';
require_once $root . '/php/model/format_mysqli_result.php';
class  ModOrdersApi
{
    private $myorder;
    private $response;
    function __construct()
    {
        $this->myorder = new Orders();
        $this->response = new responseJSON();
    }

    public function modExpress()
    {
         $res = $this->myorder->modExpress();
         if($res)
         {
             $this->response->setResponse(200,"OK","快递信息修改成功",["express"=>$_POST["express_number"]]);
         }
         else
         {
            $this->response->defaultRespone();
         }
         return $this->response->getResponse();
    }

    public function modAddress()
    {
        $res = $this->myorder->modAddress();
        if($res)
        {
            $this->response->setResponse(200,"OK","订单地址修改成功",["address"=>$_POST["address"]]);
        }
        else
        {
           $this->response->defaultRespone();
        }
        return $this->response->getResponse();
    }

    public function modState()
    {
        $res = $this->myorder->modState();
        if($res)
        {
            $this->response->setResponse(200,"OK","订单状态修改成功",["state"=>$_POST["state"]]);
        }
        else
        {
           $this->response->defaultRespone();
        }
        return $this->response->getResponse();
    }

    public function modOrder()
    {
        $res = $this->myorder->modOrders();
        if($res)
        {
            $this->response->setResponse(200,"OK","订单信息修改成功",["order_id"=>$_POST["order_id"]]);
        }
        else
        {
           $this->response->defaultRespone();
        }
        return $this->response->getResponse();
    }

    public function modDetail()
    {
        $res = $this->myorder->modDetail();
        if($res)
        {
            $this->response->setResponse(200,"OK","订单货物列表修改成功",["detail_id"=>$_POST["detail_id"]]);
        }
        else
        {
           $this->response->defaultRespone();
        }
        return $this->response->getResponse();
    }

    public function delDetail()
    {
        $res = $this->myorder->delDetail();
        if($res)
        {
            $this->response->setResponse(200,"OK","删除成功",["detail_id"=>$_POST["detail_id"]]);
        }
        else
        {
           $this->response->defaultRespone();
        }
        return $this->response->getResponse();
    }


    public function run()
    {
        if(isset($_POST["type"]))
        {
            switch($_POST["type"])
            {
                case 1:
                    $data = $this->modExpress();
                break;
                case 2:
                    $data = $this->modAddress();
                break;
                case 3:
                    $data = $this->modState();
                break;
                case 4:
                    $data = $this->modOrder();
                break;
                case 5:
                    $data = $this->modDetail();
                break;
                case 6:
                    $data = $this->delDetail();
                break;
                default:
                    $this->response->defaultRespone();
                    $data = $this->response->getResponse();
                break;
            }
        }
        else
        {
            $this->response->defaultRespone();
            $data = $this->response->getResponse();
        }
        return $data;
    }
}

$me = new ModOrdersApi();
echo $me->run();