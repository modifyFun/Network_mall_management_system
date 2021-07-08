<?php
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . '/php/model/DB.php';
require_once $root . '/php/model/checkListEmpty.php';

class Orders
{
    /**
     * 获取订单列表
     *
     * @param [array] $arr start起始  pageSize列表大小
     * @return mysqli_result
     */
    public function orderList()
    {

        $sql = "select * from orders"; //LIMIT {$arr["start"]},{$arr["pageSize"]}
        $mydb = new DB_connect();
        $results = $mydb->query($sql);

        return $results;
    }
    /**
     * 订单数目
     *
     * @return mysqli_reslut
     */
    public function countOrder()
    {
        $sql = "select count(order_id) as count from orders";
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }

    public function sumMoeny()
    {
        $sql = "select sum(price) as money from orders";
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }

    /**
     * 获取订单详情
     * 需要 get 参数
     *  "order_id"
     * @return void
     */
    public function orderDetail()
    {

        // select 
        // orders.order_id,
        // orders.user_id,
        // price,
        // address,
        // phone,
        // express_number,
        // express_date,
        // orders.state,
        // order_date,
        // goods.goods_id,
        // goods.name,
        // goods_num,
        // order_detail.sale_price
        // from 
        // orders,order_detail,goods 
        // where 
        // orders.order_id=order_detail.order_id 
        // and goods.goods_id = order_detail.goods_id 

        if (isset($_GET['order_id'])) {
            $sql = "select 
                    orders.order_id,
                    orders.price,
                    orders.user_id,
                    order_detail.goods_id,
                    detail_id,
                    orders.state,
                    address,
                    phone,
                    express_number,
                    express_date,
                    order_date,
                    name,
                    goods_img,
                    order_detail.sale_price,
                    order_detail.goods_num
                    from orders 
                    left join order_detail 
                    on orders.order_id = order_detail.order_id
                    LEFT JOIN goods on
                    order_detail.goods_id=goods.goods_id            
                    where orders.order_id={$_GET['order_id']}
                    ";
                    // echo $sql;
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
        }
        return $results;
    }

    /**
     * 根据用户id查找订单
     *
     * @param [int] $search
     * @return mysqli_result
     */
    public function searchByUserId($search)
    {
        if (isset($search)) {
            $sql = "select * from orders where user_id ={$search}";
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
        }
        return $results;
    }

    /**
     * 根据订单 id 查找订单
     *
     * @param [int] $search
     * @return mysqli_result
     */
    public function searchByOrderId($search)
    {
        if (isset($search)) {
            $sql = "select * from orders where order_id ={$search}";
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
        }
        return $results;
    }

    /**
     * 根据订单状态查找订单
     *
     * @param [int] $search
     * @return mysqli_result
     */
    public function searchByOrderState($search)
    {
        if (isset($search) ) {
            $sql = "select * from orders where state ={$search}";
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
        }
        return $results;
    }

    /**
     * 根据订单状态计算订单数
     *
     * @param [int] $search 
     * @return mysqli_result
     */
    public function searchCountByOrderState($search)
    {
        if (isset($search)) {
            $sql = "select count(order_id) as count from orders where state = {$search}";
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
        }
        return $results;
    }

    /**
     * 修改快递单号
     * 需要post参数
     *  "express_number"
     *  "order_id"      
     * @return mysqli_result
     */
    public function modExpress()
    {
        $postArr = [
            "express_number",
            "order_id"
        ];
        if (postIsSet($postArr)["status"]) {
            $time = time();
            $sql = "update orders set express_number={$_POST["express_number"]},express_date={$time},state=1 where order_id={$_POST["order_id"]}";
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
        }
        return $results;
    }

    /**
     * 修改地址
     * 需要post参数
     *  "address"
     *  "order_id"
     * @return mysqli_result
     */
    public function modAddress()
    {
        $postArr = [
            "address",
            "order_id"
        ];
        if (postIsSet($postArr)["status"]) {
            $sql = "update orders set address='{$_POST["address"]}' where order_id={$_POST["order_id"]}";
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
        }
        return $results;
    }
    /**
     * 修改订单状态
     * 需要post参数
     *  "state"
     *  "order_id"
     * @return void
     */
    public function modState()
    {
        $postArr = [
            "state",
            "order_id"
        ];
        if (postIsSet($postArr)["status"]) {
            $sql = "update orders set state={$_POST["state"]} where order_id={$_POST["order_id"]}";
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
        }
        return $results;
    }
    /**
     * 修改订单内容
     * 需要post信息
     *  "express_number"
     *  "order_id"
     *  "price"
     *  "address"
     *  "phone"
     *  "express_number"
     *  "state"        
     * @return void
     */
    public function modOrders()
    {
        $postArr = [
            "express_number",
            "order_id",
            "address",
            "phone",
            "state"
        ];
        // var_dump(postIsSet($postArr));
        if (postIsSet($postArr)["status"]) {
            $sql = "update orders set 
                express_number={$_POST["express_number"]},
                address='{$_POST["address"]}',
                phone={$_POST["phone"]},
                state={$_POST["state"]}
                where 
                order_id={$_POST["order_id"]}
            ";
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
        }
        return $results;
    }

    public function modDetail()
    {
        $postArr = [
            "goods_num",
            "sale_price",
            "detail_id",
        ];
        if (postIsSet($postArr)["status"]) {
            $sql = "update order_detail 
            set goods_num = {$_POST['goods_num']},
            sale_price ={$_POST['sale_price']} 
            where detail_id = {$_POST['detail_id']}";
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
        }
        return $results;
    }
    public function delDetail()
    {
        if(isset($_POST["detail_id"]))
        {
            $sql ="delete from order_detail where detail_id = {$_POST["detail_id"]}" ;
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
        }
        return $results;
    }

}


/*
    public function addOrder()
    {
        $postArr = [
            "user_id",
            "price",
            "address",
            "phone",
            "express_number",
            "express_date",
            "sate",
            "order_date",
            "detail"
        ];
        if(postIsSet($postArr)["status"])
        {
            $sql = "";
        }
    }
    */