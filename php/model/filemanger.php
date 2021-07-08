<?php
class FileManger
{
    public $maxsize = 2; //1M
    public $errmsg = "";
    public $ext = "png,jpg,bmp,gif";

    //上传大小是否符合
    function isAllowSize($size)
    {
        if ($size <= $this->maxsize * 1024 * 1024) {
            return true;
        } else {
            return false;
        }
    }

    //判断后缀名是否符合
    function isAllowExt($ext)
    {
        return in_array(strtolower($ext), explode(',', $this->ext));
    }

    //获取文件后缀名
    function getFileExt($file)
    {
        $arr = explode('.', $file);
        return end($arr);
    }

    //图片上传，$pickey为input的name值，$path保存路径（相对于根目录）
    function upload($pickey, $path)
    {
        if (!isset($_FILES[$pickey])) {
            return [
                "status"=>false,
                "message"=>'文件不存在'
            ];
        }

        if ($_FILES[$pickey]['error'] != 0) {
            $this->errmsg = $this->getErrorType($_FILES[$pickey]['error']);
            return [
                "status"=>false,
                "message"=> $this->errmsg
            ];
        }
        $file_ext = $this->getFileExt($_FILES[$pickey]['name']);
        // echo $file_ext;
        if (!$this->isAllowExt($file_ext)) {
            $this->errmsg = "文件后缀名不符合";
            return [
                "status"=>false,
                "message"=> $this->errmsg
            ];
        }
        // echo $_FILES[$pickey]['size'];
        if (!$this->isAllowSize($_FILES[$pickey]['size'])) {
            $this->errmsg = "大小超过限制";
            return [
                "status"=>false,
                "message"=> $this->errmsg
            ];
        }

        $str = "abcdefjhijkmnpqrst23456789";
        $filename = date("YmdHis", time()) . substr(str_shuffle($str), 0, 6);
        $childDir = date("Ymd", time());
        $root = $_SERVER['DOCUMENT_ROOT'];
        $save_path = $root.$path;
        $dir = $this->makeDir($save_path,$childDir);

        if (move_uploaded_file($_FILES[$pickey]['tmp_name'], $dir . '/' . $filename . '.' . $file_ext)) {
            return [
                "status"=>true,
                "message"=> "上传成功",
                "path"=> $path . $childDir. '/' .  $filename . '.' . $file_ext
            ];
        } else {
            $this->errmsg = "上传失败";
            return false;
        }
    }

    //创建目录
    function makeDir($save_path,$childDir)
    {
        $path = $save_path . '/' .$childDir;

        if (is_dir($path) || mkdir($path, 0777, true)) //不存在该目录文件，创建
        {
            // echo $path;
            return $path;
        } else {
            return false;
        }
    }

    //错误类型分析
    function getErrorType($error)
    {
        $errmsg = "";
        switch ($error) {
            case 0:
                $errmsg = "文件上传成功";
                break;
            case 1:
                $errmsg = "上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值";
                break;
            case 2:
                $errmsg = "上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值";
                break;
            case 3:
                $errmsg = "文件只有部分被上传";
                break;
            case 4:
                $errmsg = "没有文件被上传";
                break;
            case 6:
                $errmsg = "找不到临时文件夹";
                break;
            case 7:
                $errmsg = "文件写入失败";
                break;
        }
        return $errmsg;
    }
}
