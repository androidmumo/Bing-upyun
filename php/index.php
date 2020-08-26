<?php
//获取图片链接***
$json_content = file_get_contents('https://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=zh-CN');
$json_content = json_decode($json_content, true);
$imgurl = 'https://cn.bing.com' . $json_content['images'][0]['url'];

//保存图片***
function saveImage($path){
    $dateToday = gmdate('d-M-Y', time() + 3600 * 8);
    $image_name = 'bing/' . $dateToday . '.jpg';
    ob_start();
    readfile($path);
    $img = ob_get_contents();
    ob_end_clean();
    //$image_name就是要保存到什么路径,默认只写文件名的话保存到根目录
    $fp = fopen($image_name, 'w'); //保存的文件名称用的是链接里面的名称
    fwrite($fp, $img);
    fclose($fp);
}
saveImage($imgurl);

//上传图片到又拍云***
//又拍云连接信息
$bucketName   = '********'; //你的又拍云存储库
$operatorName = '********'; //你的存储库操作员
$operatorPwd  = '********'; //你的存储库操作员密码

//被上传的文件路径
$dateToday = gmdate('d-M-Y', time() + 3600 * 8);
$filePath = 'bing/' . $dateToday . '.jpg';
$fileSize = filesize($filePath);
//文件上传到服务器的服务端路径 修改文件名为日期
$serverPath = 'bing/' . $dateToday . '.jpg';
$uri = "/$bucketName/$serverPath";

//生成签名时间。得到的日期格式如：Thu, 11 Jul 2014 05:34:12 GMT
$date = gmdate('D, d M Y H:i:s \G\M\T');
$sign = md5("PUT&{$uri}&{$date}&{$fileSize}&" . md5($operatorPwd));

$ch = curl_init('https://v0.api.upyun.com' . $uri);

$headers = array(
    "Expect:",
    "Date: " . $date, // header 中需要使用生成签名的时间
    "Authorization: UpYun $operatorName:" . $sign
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_PUT, true);

$fh = fopen($filePath, 'rb');
curl_setopt($ch, CURLOPT_INFILE, $fh);
curl_setopt($ch, CURLOPT_INFILESIZE, $fileSize);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);
if (curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200) {
    //"上传成功"
} else {
    $errorMessage = sprintf("UPYUN API ERROR:%s", $result);
    echo $errorMessage;
}
curl_close($ch);

//删除本地缓存文件
unlink($filePath);
?>