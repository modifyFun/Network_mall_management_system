<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . "/php/control/category.php";
require_once $root . '/php/model/responseJSON.php';
require_once $root . '/php/model/format_mysqli_result.php';

class CategoryListApi
{
    private $myCategory;
    private $response;
    function __construct()
    {
        $this->myCategory = new Category();
        $this->response = new responseJSON();
    }

    public function categorylist()
    {
        $res = $this->myCategory->categoryList();
        $data = resultToArray($res);
        if (!isset($data["isFormat"])) //判断是否转换成功
            $this->response->setResponse(200, "OK", "分类列表获取成功", $data); //设置JSON数据
        else
            $this->response->setResponse(400, "fail", "分类列表获取失败", $data);
        return $this->response->getResponse();
    }

    public function run()
    {
        return $this->categorylist();
    }
}

$me = new CategoryListApi();
echo $me->run();