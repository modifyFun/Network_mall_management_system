<?php
$root = $_SERVER['DOCUMENT_ROOT']; // 获得当前站点的根目录
require_once $root . '/php/model/DB.php';
require_once $root . '/php/model/checkListEmpty.php';
require_once $root . '/php/model/format_mysqli_result.php';
class Category
{
    public function addCategory()
    {
        $postArr = [
            "category_name",
            "category_grade",
            "parent_id",
        ];
        $flag = false;
        if (postIsSet($postArr)["status"]) {
            $sql = "insert into category(category_name,category_grade,parent_id) values ('{$_POST["category_name"]}',{$_POST["category_grade"]},{$_POST["parent_id"]})";
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
            if ($results)
                $flag = true;
        }
        return $flag;
    }

    public function categoryMaxid()
    {
        $sql = "select max(category_id) as maxid from category";
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }

    public function modCategory()
    {
         $postArr = [
            "category_id",
            "category_name"
        ];
        $flag = false;
        if (postIsSet($postArr)["status"]) {
            $sql="update category set category_name='{$_POST["category_name"]}' where category_id={$_POST["category_id"]}";
            $mydb = new DB_connect();
            $results = $mydb->query($sql);
            if ($results)
                $flag = true;
        }
        return $flag;
    }

    public function categoryList()
    {
        $sql = "select * from category";
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }
}

// $me = new Category();
// var_dump($me->categoryList());
