<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . "/php/control/category.php";
require_once $root . '/php/model/responseJSON.php';

class AddCategoryApi
{
    private $myCategory;
    private $response;
    function __construct()
    {
        $this->myCategory = new Category();
        $this->response = new responseJSON();
    }

    public function addCategory()
    {
        $res = $this->myCategory->addCategory();
        if($res)
        {
            $maxres = $this->myCategory->categoryMaxid();
        }
        $data = resultToArray($maxres);
        if (!isset($data["isFormat"])) 
            $this->response->setResponse(200,"OK","successful",$data);
        else
            $this->response->setResponse(400,"fail","添加失败",["isadd"=>false]);

        return $this->response->getResponse();
    }

    public function run()
    {
        return $this->addCategory();
    }
}

$me = new AddCategoryApi();
echo $me->run();