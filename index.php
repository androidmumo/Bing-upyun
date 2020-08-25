<?php
$dateToday = gmdate('d-M-Y');
$image_name = 'bing/' . $dateToday . '.jpg';
$imgurl = 'https://***.***.***/' . $image_name; //此处填又拍云加速域名。注：结尾的 / 不能省略
header("Location: $imgurl");
?>