<?php
/*
版权信息可删除，但请勿修改
Copyright © 2020 by m@mcloc.cn
*/

//又拍云连接信息
$config['bucketName']    = '********';  //你的又拍云存储库
$config['operatorName']  = '********';  //你的存储库操作员
$config['operatorPwd']   = '********';  //你的存储库操作员密码
$config['domainName']    = '********';  //又拍云加速域名。注：结尾的 / 不能省略。如：'https://upyun.yourdom.com/'

//延时
$config['delay'] = 310; //默认延时310s，不建议修改

return $config;