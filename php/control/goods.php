<?php
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . '/php/model/DB.php';
require_once $root . '/php/model/checkListEmpty.php';

class Goods
{

    /**
     * 上架商品
     * 成功则返回 true
     * 需要 post 参数：
     *  "category_id",
     *  "name",
     *  "goods_img",
     *  "intro",
     *  "shop_price",
     *  "sale_price",
     *  "goods_price",
     *  "inventor" 
     * @return bool
     */
    public function putaway()
    {
        $flag=false;
        $postData = [
            "category_id",
            "name",
            "goods_img",
            "intro",
            "shop_price",
            "sale_price",
            "goods_price",
            "inventor" 
        ];
        // var_dump(postIsSet($postData));
        if (postIsSet($postData)["status"]) {
            $category_id = $_POST["category_id"];
            $name = $_POST["name"];
            $goods_img = $_POST["goods_img"];
            $intro = $_POST["intro"];
            $deatail = $_POST["detail"] ?? " ";
            $shop_price = $_POST["shop_price"];
            $sale_price = $_POST["sale_price"];
            $goods_price = $_POST["goods_price"];
            $sale_num = $_POST["sale_num"] ?? 0;
            $inventor = $_POST["inventor"];
            $state = $_POST["state"] ?? 1;
            $time = time();
            $sql = "insert into goods (
                        category_id,
                        name,
                        goods_img,
                        intro,detail,
                        shop_price,
                        sale_price,
                        goods_price,
                        sale_num,
                        inventor,
                        state,
                        modtime) 
                    values (
                        {$category_id},
                        '{$name}',
                        '{$goods_img}',
                        '{$intro}',
                        '{$deatail}',
                        {$shop_price},
                        {$sale_price},
                        {$goods_price},
                        {$sale_num},
                        {$inventor},
                        {$state},
                        '{$time}')
            ";
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
            if($results)
                $flag=true;
        }
        return $flag;
    }
    /**
     * 下架商品
     * 成功则返回true
     * 需要post参数
     *  "goods_id"
     * @return bool
     */
    public function soldout()
    {
        if(isset($_POST["goods_id"]))
        {
            $sql="update goods set state=3 where goods_id={$_POST["goods_id"]}";
            // $sql="update goods set state=0 where goods_id=10";
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
            return $results;
        }
    }

    /**
     * 修改商品
     * 成功放回 true
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
     * @return bool
     */
    public function modGoods()
    {
        $postData = [
            "goods_id",
            "category_id",
            "name",
            "goods_img",
            "intro",
            "shop_price",
            "sale_price",
            "goods_price",
            "inventor",
            "state"
        ];
       
        if (postIsSet($postData)["status"]) {
            $time = time();
            $sql = "update goods set
            category_id={$_POST["category_id"]},
            name='{$_POST["name"]}',
            goods_img='{$_POST["goods_img"]}',
            intro='{$_POST["intro"]}',
            detail='{$_POST["detail"]}',
            shop_price={$_POST["shop_price"]},
            sale_price={$_POST["sale_price"]},
            goods_price={$_POST["goods_price"]},
            inventor={$_POST["inventor"]},
            state={$_POST["state"]},
            modtime='{$time}'
            where goods_id = {$_POST["goods_id"]}
            ";
        }
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }

    public function addgoods()
    {
        if(isset($_POST["inventor"])&&isset($_POST["goods_id"]))
        {
            $sql = "update goods set inventor={$_POST["inventor"]} where goods_id = {$_POST["goods_id"]}";
        }
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }
    /**
     * 修改商品状态
     * state： 1 在售  2缺货 3下架
     * 需要参数
     *  "goods_id"
     *   "state"
     * @return void
     */
    public function modGoodsState()
    {
        $postData=["goods_id","state"];
        if(postIsSet($postData)["status"])
        {
            $sql="update goods set state ={$_POST["state"]} where goods_id={$_POST["goods_id"]}";
        }
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }

    /**
     * 查找商品
     * 需要查找参数
     * @return  mysqli_result 对象
     */
    public function searchGoodsById($search)
    {
        if(isset($search))
        {
            $sql = "select 
                goods_id,goods.category_id,name,
                goods_img,intro,
                shop_price,sale_price,
                goods_price,sale_num,
                inventor,modtime,
                state,category_name 
                from goods  
                LEFT JOIN category 
                on goods.category_id=category.category_id 
                where goods_id  = {$search}
            ";
        }
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }

    //根据商品名查询
    public function searchGoodsByName($search)
    {
        if(isset($search))
        {
            
            $sql = "select 
                goods_id,goods.category_id,name,
                goods_img,intro,
                shop_price,sale_price,
                goods_price,sale_num,
                inventor,modtime,
                state,category_name 
                from goods  
                LEFT JOIN category 
                on goods.category_id=category.category_id 
                where name like '{$search}%'
            ";
        }
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }

    //根据类别查询
    public function searchGoodsByCategory($search)
    {
        if(isset($search))
        {
            $sql = "select 
                goods_id,goods.category_id,name,
                goods_img,intro,
                shop_price,sale_price,
                goods_price,sale_num,
                inventor,modtime,
                state,category_name 
                from goods  
                LEFT JOIN category 
                on goods.category_id=category.category_id 
                where category_name='{$search}'
            ";
            // echo $sql;
        }
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }

    /**
     * 根据商品状态查找
     * 1 在售  2缺货 3下架
     * @param [int] $search
     * @return  mysqli_result 对象
     */
    public function searchGoodsByState($search)
    {
        $sql = "select 
                goods_id,goods.category_id,name,
                goods_img,intro,
                shop_price,sale_price,
                goods_price,sale_num,
                inventor,modtime,
                state,category_name 
                from goods  
                LEFT JOIN category 
                on goods.category_id=category.category_id 
                where state={$search}
            ";
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }

    /**
     * 获取热销产品
     *
     * @return mysqli_result 对象
     */
    public function getHotGoods()
    {
       $sql="select goods_id,category_name,name,sale_price,sale_num 
            from 
            (select goods_id,category_id,name,sale_price,sale_num from goods ORDER BY category_id asc,sale_num desc) as temp 
            LEFT JOIN category
            on temp.category_id=category.category_id
            GROUP BY temp.category_id";
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;

    }
    /**
     * 获取缺货商品
     *
     * @return mysqli_result 对象
     */
    public function getStockout()
    {
        $sql = "select 
                goods_id,goods.category_id
                ,name,goods_img,intro,
                shop_price,sale_price,
                goods_price,sale_num,
                inventor,modtime,state
                from goods  
                where inventor< 2 and state<>3
            ";
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }

    /**
     * 获取商品列表
     *
     * @param [array] $arr  start 起始  pageSize 数量
     * @return  mysqli_result 对象
     */
    public function goods_list($arr)
    {
        
        if(listIsEmpty($arr))
        {
            $sql = "select 
                goods_id,goods.category_id,name,
                goods_img,intro,
                shop_price,sale_price,
                goods_price,sale_num,
                inventor,modtime,
                state,category_name 
                from goods  
                LEFT JOIN category 
                on goods.category_id=category.category_id 
                order by modtime desc
            ";
            // LIMIT {$arr["start"]},{$arr["pageSize"]}
        }
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }

    public function goodsCount()
    {
        $sql = "select count(goods_id) as count from goods";
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }

    /**
     * 将每类的商品数量查询出来
     *
     * @return mysqli_result
     */
    public function countByGroupCategory()
    {
        $sql="select 
        goods.category_id,
        category_name,
        count(goods_id) as count 
        from goods
        LEFT JOIN category on goods.category_id=category.category_id
        group by category_id";

        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
        /*select 
        temp.category_id,category_name,count 
        from 
        (select goods.category_id,count(goods_id) as count from goods group by category_id ) 
        as temp,
        category 
        where 
        category.category_id=temp.category_id */
    }

    /**
     * 查询指定类型商品的数量
     *
     * @return void
     */
    public function searchCountByCategoryId()
    {
        $sql = "select count(goods_id) as count from goods where category_id={$_GET["category_id"]}";
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }


    /**
     * 获取商品详情
     *
     * @param [int] $goods_id
     * @return  mysqli_result 对象
     */
    public function getGoodsDetail($goods_id)
    {
        if(isset($goods_id))
            $sql = "select * from goods  
                LEFT JOIN category 
                on goods.category_id=category.category_id
                where goods_id={$goods_id}";

        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }
}


