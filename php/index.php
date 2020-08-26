<?php
//引入配置文件
$config = include 'config.php';

//初始化又拍云信息
$bucketName   = $config['bucketName'];
$operatorName = $config['operatorName'];
$operatorPwd  = $config['operatorPwd'];

//获取图片链接
$json_content = file_get_contents('https://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=zh-CN');
$json_content = json_decode($json_content, true);
$imgurl = 'https://cn.bing.com' . $json_content['images'][0]['url'];

//获取当前时间
$dateToday = gmdate('d-M-Y', time() + 3600 * 8);

//保存图片函数
function saveImage($image_name, $url_path)
{
    ob_start();
    readfile($url_path);
    $img = ob_get_contents();
    ob_end_clean();
    //$image_name就是要保存到什么路径,默认只写文件名的话保存到根目录
    $fp = fopen($image_name, 'w'); //保存的文件名称用的是链接里面的名称
    fwrite($fp, $img);
    fclose($fp);
}

//保存原始图片到本地
$image_path_1 = 'bing/' . $dateToday . '.jpg';
saveImage($image_path_1, $imgurl);

//上传图片到又拍云函数
function upImage($bucketName, $operatorName, $operatorPwd, $localFilePath, $upFilePath)
{
    $filePath = $localFilePath;
    $fileSize = filesize($filePath);
    //文件上传到服务器的服务端路径 修改文件名为日期
    $serverPath = $upFilePath;
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
}

//上传原始图片
$localFilePath = 'bing/' . $dateToday . '.jpg'; //被上传的文件路径
$upFilePath = 'bing/' . $dateToday . '/' . $dateToday . '.jpg'; //文件上传到服务器的服务端路径 修改文件名为日期
upImage($bucketName, $operatorName, $operatorPwd, $localFilePath, $upFilePath);

//删除本地缓存文件
unlink($localFilePath);
