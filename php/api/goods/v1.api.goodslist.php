<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . "/php/control/goods.php";
require_once $root . '/php/model/responseJSON.php';
require_once $root . '/php/model/checkListEmpty.php';
require_once $root . '/php/model/format_mysqli_result.php';
/**
 * 获取商品列表 Api
 * 需要 get 参数
 * "start" 起始页
 * "pageSize" 列表大小
 */
class GoodsListApi
{
    private $mygoods;
    private $response;
    function __construct()
    {
        $this->mygoods = new Goods();
        $this->response = new responseJSON();
    }

    /**
     * 商品列表
     * 需要 get 参数
     *  'startPage' 起始页
     *  'pageSize'  一页列表大小
     * @return JSON
     */
    public function goodsList()
    {
        $getArr = [
            'startPage',
            'pageSize'
        ];
        //设置limit参数
        if (getIsSet($getArr)["status"]) {
            $arr = [
                'start' => $_GET["startPage"] * $_GET["pageSize"],
                'pageSize' => $_GET["pageSize"]
            ];
        }

        $res = $this->mygoods->goods_list($arr); //获取商品列表
        $data = resultToArray($res); //mysqli_result 转换为数组 并追加入 data数组

        if (!isset($data["isFormat"])) //判断是否转换成功
        {
            $coutRes=$this->mygoods->goodsCount(); //获取列表大小
            $size = resultToArray($coutRes); //取得结果
            $this->response->setResponse2(200, "OK", "successful",$size[0]['count'], $data); //设置JSON数据
        }    
        else
            $this->response->setResponse2(400, "fail", "商品列表获取失败",0,$data);
        return $this->response->getResponse2();
    }

    /**
     * 热门商品列表
     *
     * @return void
     */
    public function hotGoods()
    {
        $res = $this->mygoods->getHotGoods(); //获取热门商品 mysqli_result
        $data = resultToArray($res); //mysqli_result 转换为数组

        if (!isset($data["isFormat"])) //判断是否转换成功
            $this->response->setResponse2(200, "OK", "热门商品列表获取成功",count($data), $data); //设置JSON数据
        
        else
            $this->response->setResponse2(400, "fail", "热门商品列表获取失败",0,$data);
        return $this->response->getResponse2();
    }

    /**
     * 缺货商品列表
     *
     * @return void
     */
    public function stockout()
    {
        $res = $this->mygoods->getStockout(); //获取缺货商品 mysqli_result
        $data = resultToArray($res); //mysqli_result 转换为数组
        if (!isset($data["isFormat"])) //判断是否转换成功
            $this->response->setResponse2(200, "OK", "缺货商品列表获取成功",count($data), $data); //设置JSON数据
        else
            $this->response->setResponse2(400, "fail", "缺货商品列表获取失败",0, $data);
        return $this->response->getResponse2();
    }

    /**
     * 入口函数
     * 需要get参数
     * type 获取列表的类型
     * @return JSON
     */
    public function run()
    {
        $data = "";
        if (isset($_GET["type"])) {
            switch ($_GET["type"]) {
                case 1:
                    $data = $this->goodsList();
                    break;
                case 2:
                    $data = $this->hotGoods();
                    break;
                case 3:
                    $data = $this->stockout();
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
$me = new GoodsListApi();
echo $me->run();
