<?php
$delay = 310; //延时310s
$dateToday = gmdate('d-M-Y', time() + 3600 * 8 - $delay);
$image_name = 'bing/' . $dateToday . '.jpg';
$imgurl = 'https://***.***.***/' . $image_name; //此处填又拍云加速域名。注：结尾的 / 不能省略
header("Location: $imgurl");
?>