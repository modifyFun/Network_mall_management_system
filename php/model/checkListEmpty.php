<?php

/**
 * 检查列表的值是否为空 工具类
 * 存在空值则将空的键值对存入数组 并将status 改为true
 * 不存在 则返回 ["status"=>false]
 * @param [type] $arr
 * @return arr
 */
    function listIsEmpty($arr)
    {
        $res=["status"=>false];
        foreach($arr as $key => $value){
            if(!isset($value))
            {
                $respone["status"]=true;
                $respone[]=[$key=>$value];
            }
            // echo "{$key}==>{$value}<br>";
        }
        return $res;
    }

/**
 * 检测post参数是否存在
 * 存在空值则将空的键值对存入数组 并将status 改为true
 * 不存在 则返回 ["status"=>false]
 * @param [array] $arr
 * @return array
 */
    function postIsSet($arr)
    {
        $res=["status"=>true];
        foreach($arr as $key => $value){
            if(!isset($_POST[$value]))
            {
                $res["status"]=false;
                $res[]=[$key=>$value];
            }
            // echo "{$key}==>{$value}<br>";
        }
        return $res;
    }

    /**
     * 检查get参数是否设置
     * 存在空值则将空的键值对存入数组 并将status 改为true
     * 不存在 则返回 ["status"=>false]
     * @param [array] $arr
     * @return array
     */
    function getIsSet($arr)
    {
        $res=["status"=>true];
        foreach($arr as $key => $value){
            if(!isset($_GET[$value]))
            {
                $res["status"]=false;
                $res[]=[$key=>$value];
            }
            // echo "{$key}==>{$value}<br>";
        }
        return $res;
    }
?>