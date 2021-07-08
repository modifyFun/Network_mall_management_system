<?php
/**
 * 将mysqli_result 对象结果集 转化为 数组
 *
 * @param [mysqli_result] $result
 * @return Array
 */
    function resultToArray($result)
    {
        $data=[];
        if($result)
        {
            while ($row = $result->fetch_assoc())
            {
                $data[]=$row;
            }
        }
        else
        {
            $data = [
                "isFormat"=>false
            ];
        }
        return $data;
    }
?>