<?php
    /**
     * 登录 api
     */
    $root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
    require_once $root .'/php/control/ADlogin.php';
    require_once $root .'/php/model/responseJSON.php';
    class ADloginApi
    {
        /**
         * 返回api响应数据
         *
         * @return array
         */
        public function info()
        {
            $login = new ADlogin();
            $response = new responseJSON();
            $data=[];
            if($login->checkcode())
            {
                if($login->login())
                {
                    $data=[
                    "islogin"=>true,
                    "user"=>$_POST["adaccout"]
                    ];
                    $response->setResponse(200,"OK","successful",$data);
                }
                else
                {
                    $data=[
                        "islogin"=>false,
                        "user"=>$_POST["adaccout"]??""
                        ];
                    $_SESSION["captcha"]="";//销毁验证码
                    $response->setResponse(400,"fail","账号密码错误",$data);
                }
            }
            else
            {
                $data=[
                    "islogin"=>false,
                    "user"=>$_POST["adaccout"]??""
                ];
                $response->setResponse(400,"fail","验证码错误",$data);
            }
            return $response->getResponse();
        }

        /**
         * 返回json结果 
         *
         * @return JSON
         */
        function run()
        {
            return $this->info();
        }   

    }

    $loginapi=new ADloginApi();
    echo $loginapi->run();
?>