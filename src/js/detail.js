//获取url参数
let daydata = getUrlParam("daydata");

//生成bigimg
var bigImgStr = `
            <img data-src="https://bing.mcloc.cn/api/?day=${daydata}" src="https://bing.mcloc.cn/api/?day=${daydata}&thumbnail=1" class="d-block w-100 rounded preview lazy" alt="bing">
`
$("#bigimg-wrap").children(".progressive").empty().append(bigImgStr);

//图片渐进式加载
imgpro("#bigimg-wrap");

//调用ajax函数 获取此图片信息
var detailMsg = getImgMsg(daydata);
var imgSubDate = detailMsg["submission_date"];
var imgTit = detailMsg["bing_title"];
var imgUrlHd = detailMsg["bing_imgurl"];
var imgUrlUhd = detailMsg["bing_imgurluhd"];

//改变网页标题
$('title').text(imgTit);

//添加图片标题
$(".bigimg-text").empty().append(imgTit);

//评论系统
new Valine({
    el: '********',
    appId: '********',
    appKey: '********',
    path: `${imgSubDate}`
})

//将数据写入模态框
var modalImgStr = `
<img class="rounded img-fluid" src="https://bing.mcloc.cn/api/?day=${daydata}" alt="">
`
$(".modal-img-wrap").empty().append(modalImgStr);

/* 点击模态框按钮下载图片 */
$("#btnHd").click(function () {
    var x = new XMLHttpRequest();

    var resourceUrl = imgUrlHd;
    x.open("GET", resourceUrl, true);
    x.responseType = 'blob';

    x.onload = function (e) {
        // ie10+
        if (navigator.msSaveBlob) {
            var name1 = "bingHd";
            return navigator.msSaveBlob(x.response, name1);
        } else {
            var url = window.URL.createObjectURL(x.response)
            var a = document.createElement('a');
            a.href = url;
            a.download = today;
            a.click();
        }
    }
    x.send();
});

$("#btnUhd").click(function () {
    var x = new XMLHttpRequest();

    var resourceUrl = imgUrlUhd;
    x.open("GET", resourceUrl, true);
    x.responseType = 'blob';

    x.onload = function (e) {
        // ie10+
        if (navigator.msSaveBlob) {
            var name2 = "bingUhd";
            return navigator.msSaveBlob(x.response, name2);
        } else {
            var url = window.URL.createObjectURL(x.response)
            var a = document.createElement('a');
            a.href = url;
            a.download = today;
            a.click();
        }
    }
    x.send();
});
/* 点击模态框按钮下载图片 end */