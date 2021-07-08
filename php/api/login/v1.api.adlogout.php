<?php
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . '/php/control/ADlogin.php';
require_once $root . '/php/model/responseJSON.php';

function logout()
{
    $login = new ADlogin();
    $response = new responseJSON();
    if ($login->logout()) {
        $data = [
            "islogout" => true,
        ];
        $response->setResponse(200, "OK", "successful", $data);
    } else {
        $data = [
            "islogout" => false,
        ];
        $response->setResponse(400, "fail", "注销失败", $data);
    }
    return $response->getResponse();
}

echo logout();
?>
