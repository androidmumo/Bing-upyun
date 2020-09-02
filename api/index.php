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

//引入配置文件
$config = include 'php/config.php';

//初始化配置
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

    if (!$day) {
        $dateToday = gmdate('d-M-Y', time() + 3600 * 8 - $delay);
        $dateEnd = $dateToday;
    } else {
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
    } else if ($gray == "true") {
        $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '-gray' . '.jpg';
    } else {
        $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '.jpg';
    }

    $imgurl = $cdnDom . $image_name;
    header("Location: $imgurl");
}
