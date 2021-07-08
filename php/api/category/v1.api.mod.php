<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . "/php/control/category.php";
require_once $root . '/php/model/responseJSON.php';

class ModCategoryApi
{
    private $myCategory;
    private $response;
    function __construct()
    {
        $this->myCategory = new Category();
        $this->response = new responseJSON();
    }

    public function modCategory()
    {
        $res = $this->myCategory->modCategory();
        if($res)
            $this->response->setResponse(200,"OK","successful",["isadd"=>true]);
        else
            $this->response->setResponse(400,"fail","修改失败",["isadd"=>false]);

        return $this->response->getResponse();
    }
    
    public function run()
    {
        return $this->modCategory();
    }
}

$me = new ModCategoryApi();
echo $me->run();