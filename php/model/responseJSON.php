<?php
/**
 * 响应JSON数据
 */
    class responseJSON
    {
       
        private $data;
        private $code;
        private $message;
        private $status;
        private $size;
        /**
         * 构造函数
         */
        function __construct()
        {
            $this->data=[];
            $this->code=100;
            $this->message="running";
            $this->status="RUN";
        }
        /**
         * 设置响应数据1
         *
         * @param [INT] $code
         * @param [STR] $status
         * @param [STR] $message
         * @param [ARRAY] $data
         * @return void
         */
        public function setResponse($code,$status,$message,$data)
        {
            foreach($data as $value)
                $this->data[]=$value;
            $this->code=$code;
            $this->message=$message;
            $this->status=$status;
        }
         /**
         * 设置响应数据2
         *
         * @param [INT] $code
         * @param [STR] $status
         * @param [STR] $message
         * @param [INT] $size
         * @param [ARRAY] $data
         * @return void
         */
        public function setResponse2($code,$status,$message,$size,$data)
        {
            foreach($data as $value)
                $this->data[]=$value;
            $this->code=$code;
            $this->message=$message;
            $this->status=$status;
            $this->size = $size;
        }
        public function defaultRespone()
        {
            $this->data=[];
            $this->code=400;
            $this->message="操作无效";
            $this->status="fail";
        }
        /**
         * 获取响应数据1
         *
         * @return void
         */
        public function getResponse()
        {
            return json_encode([
                "code"=>$this->code,
                "status"=>$this->status,
                "message"=>$this->message,
                "data"=>$this->data
            ]);
        }

        public function getResponse2()
        {
            return json_encode([
                "code"=>$this->code,
                "status"=>$this->status,
                "message"=>$this->message,
                "size"=>$this->size??0,
                "data"=>$this->data
            ]);
        }
    }
?>