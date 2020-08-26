<?php
$config = include 'php/config.php'; //引入配置文件
$cdnDom = $config['domainName'];
$delay = 310; //延时310s
$dateToday = gmdate('d-M-Y', time() + 3600 * 8 - $delay);
$image_name = 'bing/' . $dateToday. '/' . $dateToday . '.jpg';
$imgurl = $cdnDom . $image_name; //此处填又拍云加速域名。注：结尾的 / 不能省略
header("Location: $imgurl");
?>