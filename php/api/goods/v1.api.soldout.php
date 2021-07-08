<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root."/php/control/goods.php";
require_once $root .'/php/model/responseJSON.php';
/**
 * 下架商品 api
 * 需要post参数
 *  "goods_id"
 */
class SoldoutApi
{
    private $mygoods;
    private $response;
    function __construct()
    {
        $this->mygoods=new Goods();
        $this->response = new responseJSON();
    }
    public function soldout()
    {
        $res = $this->mygoods->soldout();
        $data=[];
        if($res)
        {
            $data=[
                "isSoldout"=>true
            ];
            $this->response->setResponse(200,"OK","successful",$data);
        }
        else
        {
            $data=[
                "isSoldout"=>false
            ];
            $this->response->setResponse(400,"fail","下架失败",$data);
        }
        return $this->response->getResponse();
    }

    public function run()
    {
        return $this->soldout();
    }
}

$me = new SoldoutApi();
echo $me->run();