<?php
/*
版权信息可删除，但请勿修改
Copyright © 2020 by m@mcloc.cn
*/
$blur = $_REQUEST['blur'];
$gray = $_REQUEST['gray'];
$day = $_REQUEST['day'];
$config = include 'php/config.php'; //引入配置文件
$cdnDom = $config['domainName'];
$delay = $config['delay'];

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
