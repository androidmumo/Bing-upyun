<?php
/*
版权信息可删除，但请勿修改
Copyright © 2020 by m@mcloc.cn
*/
$blur = $_REQUEST['blur'];
$gray = $_REQUEST['gray'];
$config = include 'php/config.php'; //引入配置文件
$cdnDom = $config['domainName'];
$delay = $config['delay'];
$dateToday = gmdate('d-M-Y', time() + 3600 * 8 - $delay);

if ($blur) {
    if ($blur == "5") {
        $image_name = 'bing/' . $dateToday . '/' . $dateToday . '-gaussblur-5' . '.jpg';
    }
    if ($blur == "15") {
        $image_name = 'bing/' . $dateToday . '/' . $dateToday . '-gaussblur-15' . '.jpg';
    }
    if ($blur == "25") {
        $image_name = 'bing/' . $dateToday . '/' . $dateToday . '-gaussblur-25' . '.jpg';
    }
} else if ($gray == "true") {
    $image_name = 'bing/' . $dateToday . '/' . $dateToday . '-gray' . '.jpg';
} else {
    $image_name = 'bing/' . $dateToday . '/' . $dateToday . '.jpg';
}

$imgurl = $cdnDom . $image_name;
header("Location: $imgurl");
