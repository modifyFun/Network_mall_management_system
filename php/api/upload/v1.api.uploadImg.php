<?php
@session_start();
if(!isset($_SESSION["loginpass"]))
    return ;
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . '/php/model/responseJSON.php';
require_once $root . '/php/model/filemanger.php';
class UploadImgApi
{
    private $fileManger;
    private $response;
    private $root;
    function __construct()
    {
        $this->root = $_SERVER['DOCUMENT_ROOT'];
        $this->response = new responseJSON();
        $this->fileManger = new FileManger();
    }
    public function uploadImg()
    {
        
        if(isset($_POST["oldImg"]))
        {
            $delFile = $this->root . $_POST["oldImg"];
            @unlink($delFile);
        }
        $saveDir = "/upload/goods_img/";
        $res =  $this->fileManger->upload('file',$saveDir);
        if ($res["status"]) {
            $res["path"]=$res["path"];
            // var_dump($res);
            $this->response->setResponse(200,"ok","上传成功",$res);
        }
        else
        {
            $this->response->setResponse(400,"fail","上传失败",$res);
        }
        return $this->response->getResponse();
    }
}
$me = new UploadImgApi();
echo $me->uploadImg();
