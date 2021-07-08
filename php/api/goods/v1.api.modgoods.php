<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root."/php/control/goods.php";
require_once $root .'/php/model/responseJSON.php';
/**
 * 修改商品信息
 */
class ModGoodsApi
{
    private $mygoods;
    private $response;
    function __construct()
    {
        $this->mygoods=new Goods();
        $this->response = new responseJSON();
    }

/**
 * 修改商品信息
 * 需要post参数
 *   "goods_id",
 *   "category_id",
 *   "name",
 *   "goods_img",
 *   "intro",
 *   "shop_price",
 *   "sale_price",
 *   "goods_price",
 *   "inventor",
 *   "state"
 * @return JSON
 */
    public function modGoods()
    {
        $res = $this->mygoods->modGoods();//执行修改商品函数
        $data=[];
        if($res)
        {
            $data = [
                "ismod"=>true
            ];
            $this->response->setResponse(200,"OK","修改成功",$data); //设置JSON数据
        }
        else
        {
            $data = [
                "ismod"=>false
            ];
            $this->response->setResponse(400,"fail","修改失败",$data);
        }
        return $this->response->getResponse();
    }
    /**
     * 修改商品状态
     * 需要POST参数
     *  "goods_id"
     *   "state"
     * @return JSON
     */
    public function modGoodsState()
    {
        $res = $this->mygoods->modGoodsState();
        $data=[];
        if($res)
        {
            $data = [
                "ismod"=>true
            ];
            $this->response->setResponse(200,"OK","修改成功",$data);
        }
        else
        {
            $data = [
                "ismod"=>false
            ];
            $this->response->setResponse(400,"fail","修改失败",$data);
        }
        return $this->response->getResponse();
    }

    public function modInventor()
    {
        $res = $this->mygoods->addgoods();
        $data=[];
        if($res)
        {
            $data = [
                "ismod"=>true
            ];
            $this->response->setResponse(200,"OK","修改成功",$data);
        }
        else
        {
            $data = [
                "ismod"=>false
            ];
            $this->response->setResponse(400,"fail","修改失败",$data);
        }
        return $this->response->getResponse();
    }
    
    /**
     * 入口函数
     * 需要POST参数
     *  "modType" (1修改全部信息，2修改状态信息,3修改库存)
     * @return JSON
     */
    public function run()
    {
        $res="";
        if(isset($_POST["modType"]))
        {
            switch($_POST["modType"])
            {
                case 1:
                    $res = $this->modGoods();
                break;
                case 2:
                    $res = $this->modGoodsState();
                break;
                case 3:
                    $res = $this-> modInventor();
                break;
            }
        }
        return $res;
    }
}

$me = new ModGoodsApi();
echo $me->run();