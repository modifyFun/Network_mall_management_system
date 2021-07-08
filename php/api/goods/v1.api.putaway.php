<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root."/php/control/goods.php";
require_once $root .'/php/model/responseJSON.php';
/**
 * 商品上架 api
 * 必需字段：
 *  "category_id",
 *  "name",
 *  "goods_img",
 *  "intro",
 *  "shop_price",
 *  "sale_price",
 *  "goods_price",
 *  "inventor" 
 */
class PutawayApi
{
    private $mygoods;
    private $response;
    function __construct()
    {
        $this->mygoods=new Goods();
        $this->response = new responseJSON();
    }
    public function putaway()
    {
        $res = $this->mygoods->putaway();
        $data=[];
        if($res)
        {
            $data = [
                "isput"=>true
            ];
            $this->response->setResponse(200,"OK","successful",$data);//设置JSON数据
        }
        else
        {
            $data = [
                "isput"=>false
            ];
            $this->response->setResponse(400,"fail","上架失败",$data);//设置JSON数据
        }
        return $this->response->getResponse(); //返回JSON数据
    }
    /**
     * 入口函数
     *
     * @return JSON
     */
    public function run()
    {
        return $this->putaway();
    }
}

$me = new PutawayApi();
echo $me->run();