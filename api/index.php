<?php
/*
版权信息可删除，但请勿修改
Copyright © 2020 by m@mcloc.cn
*/

//获取参数
$blur = $_REQUEST['blur'];
$gray = $_REQUEST['gray'];
$day = $_REQUEST['day'];
$type = $_REQUEST['type'];
$random = $_REQUEST['random'];
$thumbnail = $_REQUEST['thumbnail'];

//引入配置文件
$config = include 'php/config.php';

//初始化配置
$startdate = $config['startdate'];
$cdnDom = $config['domainName'];
$delay = $config['delay'];

//初始化数据库信息
$mysqlHost = $config['mysqlHost'];
$mysqlUsername = $config['mysqlUsername'];
$mysqlPassword = $config['mysqlPassword'];
$mysqlDbname = $config['mysqlDbname'];

//建立数据库连接
$conn = mysqli_connect($mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDbname);

if ($type == "json") {

    if (!$day) {
        $dateToday = gmdate('d-M-Y', time() + 3600 * 8 - $delay);
        $dateEnd1 = $dateToday;

        // 读取数据库数据
        $sql1 = "SELECT * FROM bing_tbl WHERE submission_date='$dateEnd1'";
        $result_byDid = mysqli_query($conn, $sql1);
        $result_arr_byDid = mysqli_fetch_assoc($result_byDid);
        $return = $result_arr_byDid;
        $return = json_encode($return);
    } else {
        $dateEnd1 = gmdate('d-M-Y', time() + 3600 * 8 - $delay - ($day * 3600 * 24));

        // 读取数据库数据
        $sql1 = "SELECT * FROM bing_tbl WHERE submission_date='$dateEnd1'";
        $result_byDid = mysqli_query($conn, $sql1);
        $result_arr_byDid = mysqli_fetch_assoc($result_byDid);
        $return = $result_arr_byDid;
        $return = json_encode($return);
    }

    echo $return;
} else {

    //如果没有指定获取某一天图片
    if (!$day) {
        //检查随机数参数是否为真，若为真则获取随机某天前的图片
        if ($random) {
            // 获取当前时间与程序运行时间之间的随机整数。
            $Date_1=date("Y-m-d");
            $Date_2= $startdate;
            $d1=strtotime($Date_1);
            $d2=strtotime($Date_2);
            $Days=round(($d1-$d2)/3600/24);
            $randdays = mt_rand(0, $Days);
            $dateEnd = gmdate('d-M-Y', time() + 3600 * 8 - $delay - ($randdays * 3600 * 24));
        //若不获取随机图则返回当天图片
        }else {
            $dateToday = gmdate('d-M-Y', time() + 3600 * 8 - $delay);
            $dateEnd = $dateToday;
        }
    //指定获取某n天前的图片
    }else {
        $dateEnd = gmdate('d-M-Y', time() + 3600 * 8 - $delay - ($day * 3600 * 24));
    }

    if ($blur) {
        if ($blur == "5") {
            $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '-gaussblur-5' . '.jpg';
        }
        if ($blur == "15") {
            $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '-gaussblur-15' . '.jpg';
        }
        if ($blur == "25") {
            $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '-gaussblur-25' . '.jpg';
        }
    } else if ($thumbnail) {
        if ($thumbnail == "25") {
            $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '-compress_25' . '.jpg';
        }
        if ($thumbnail == "1") {
            $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '-compress_1' . '.jpg';
        }
    } else if ($gray == "true") {
        $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '-gray' . '.jpg';
    } else {
        $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '.jpg';
    }

    $imgurl = $cdnDom . $image_name;
    header("Location: $imgurl");
}
