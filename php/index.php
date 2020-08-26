<?php
/*
版权信息可删除，但请勿修改
Copyright © 2020 by m@mcloc.cn
*/
//引入配置文件
$config = include 'config.php';

//初始化又拍云信息
$bucketName = $config['bucketName'];
$operatorName = $config['operatorName'];
$operatorPwd = $config['operatorPwd'];
$cdnDom = $config['domainName'];

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
$localFilePath = $image_path_1; //被上传的文件路径
$upFilePath = 'bing/' . $dateToday . '/' . $dateToday . '.jpg'; //文件上传到服务器的服务端路径 修改文件名为日期
upImage($bucketName, $operatorName, $operatorPwd, $localFilePath, $upFilePath);

//删除本地缓存文件
unlink($image_path_1);

//保存图片到本地gaussblur-5
$image_path_gaussblur_5 = 'bing/' . $dateToday . '-gaussblur-5' . '.jpg';
$imgurl_gaussblur_5 = $cdnDom . $upFilePath . '!/gaussblur/0x5';
saveImage($image_path_gaussblur_5, $imgurl_gaussblur_5);

//保存图片到本地gaussblur-15
$image_path_gaussblur_15 = 'bing/' . $dateToday . '-gaussblur-15' . '.jpg';
$imgurl_gaussblur_15 = $cdnDom . $upFilePath . '!/gaussblur/0x15';
saveImage($image_path_gaussblur_15, $imgurl_gaussblur_15);

//保存图片到本地gaussblur-25
$image_path_gaussblur_25 = 'bing/' . $dateToday . '-gaussblur-25' . '.jpg';
$imgurl_gaussblur_25 = $cdnDom . $upFilePath . '!/gaussblur/0x25';
saveImage($image_path_gaussblur_25, $imgurl_gaussblur_25);

//保存图片到本地gray
$image_path_gray = 'bing/' . $dateToday . '-gray' . '.jpg';
$imgurl_gray = $cdnDom . $upFilePath . '!/gray/true';
saveImage($image_path_gray, $imgurl_gray);

//上传图片gaussblur-5
$localFilePath_gaussblur_5 = $image_path_gaussblur_5;
$upFilePath_gaussblur_5 = 'bing/' . $dateToday . '/' . $dateToday . '-gaussblur-5' . '.jpg';
upImage($bucketName, $operatorName, $operatorPwd, $localFilePath_gaussblur_5, $upFilePath_gaussblur_5);

//上传图片gaussblur-15
$localFilePath_gaussblur_15 = $image_path_gaussblur_15;
$upFilePath_gaussblur_15 = 'bing/' . $dateToday . '/' . $dateToday . '-gaussblur-15' . '.jpg';
upImage($bucketName, $operatorName, $operatorPwd, $localFilePath_gaussblur_15, $upFilePath_gaussblur_15);

//上传图片gaussblur-25
$localFilePath_gaussblur_25 = $image_path_gaussblur_25;
$upFilePath_gaussblur_25 = 'bing/' . $dateToday . '/' . $dateToday . '-gaussblur-25' . '.jpg';
upImage($bucketName, $operatorName, $operatorPwd, $localFilePath_gaussblur_25, $upFilePath_gaussblur_25);

//上传图片gray
$localFilePath_gray = $image_path_gray;
$upFilePath_gray = 'bing/' . $dateToday . '/' . $dateToday . '-gray' . '.jpg';
upImage($bucketName, $operatorName, $operatorPwd, $localFilePath_gray, $upFilePath_gray);

//删除本地缓存文件gaussblur-5
unlink($image_path_gaussblur_5);

//删除本地缓存文件gaussblur-15
unlink($image_path_gaussblur_15);

//删除本地缓存文件gaussblur-25
unlink($image_path_gaussblur_25);

//删除本地缓存文件gray
unlink($image_path_gray);