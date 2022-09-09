/* 点击图片跳转到详情 */
$("#pic-js").on("click", ".pic-item", function () {
    window.location.href = `html/detail.html?daydata=${$(this).attr("data-day")}`;
})
/* 点击图片跳转到详情 end */

/* 图片渐进式加载 */
imgpro("#carousel-js");

for (let i = 0; i < 12; i++) {
    var ele = `#pic-js-son${i}`;
    imgpro(ele);
}
/* 图片渐进式加载 end */

// /* 生成轮播图文字并插入 */
// for (let i = 0; i < 3; i++) {
//     var carouselStr = "";
//     var imgMsg = getImgMsg(i);
//     var imgTit = imgMsg["bing_title"];
//     var imgTitS = imgTit.replace(/\([^\)]*\)/g, ""); //去除括号及空格
//     imgTitS = imgTitS.replace(/\s*$/g, "");

//     // var imgUrlDate = getImgUrlHd(todayTimeEn(i)); //生成HD图片url

//     carouselStr = `
//             <h5>${imgTitS}</h5>
//             <p>${imgTit}</p>
//     `
//     $(".carousel-caption").eq(i).empty().append(carouselStr);
// }
// /* 生成轮播图文字并插入 end */

// /* 生成缩略图文字并插入 */
// for (let i = 0; i < 12; i++) {
//     var imgMsg = getImgMsg(i);
//     var imgTit = imgMsg["bing_title"];
//     var imgDate = imgMsg["submission_date"];
//     var imgTitS = imgTit.replace(/\([^\)]*\)/g, ""); //去除括号及空格
//     imgTitS = imgTitS.replace(/\s*$/g, "");

//     imgTitS = `<span class="badge badge-secondary">${imgDate}</span><br>` + imgTitS;
//     // var imgUrlDate = getImgUrlCom(todayTimeEn(i)); //生成com图片url

//     $("#pic-js").children().eq(i).children("p").empty().append(imgTitS);
// }
// /* 生成缩略图文字并插入 end */


/* 轮播图文字 （递归优化） */
var dayi = 0;

function getText1() {
    $.ajax({
        type: "GET",
        async: true,
        url: "https://bing.nxingcloud.co/api/",
        data: `type=json&day=${dayi}`,
        success: function (msg) {
            var imgMsg = $.parseJSON(msg);
            var carouselStr = "";
            var imgTit = imgMsg["bing_title"];
            var imgTitS = imgTit.replace(/\([^\)]*\)/g, ""); //去除括号及空格
            imgTitS = imgTitS.replace(/\s*$/g, "");

            // var imgUrlDate = getImgUrlHd(todayTimeEn(i)); //生成HD图片url

            carouselStr = `
                    <h5>${imgTitS}</h5>
                    <p>${imgTit}</p>
            `
            $(".carousel-caption").eq(dayi).empty().append(carouselStr);

            if (dayi > 1) {
                return;
            } else {
                dayi = dayi + 1;
                getText1();
            }
        }
    });
}
getText1();
/* 轮播图文字 （递归优化） end */

/* 缩略图文字 （递归优化） */
var dayj = 0;

function getText2() {
    $.ajax({
        type: "GET",
        async: true,
        url: "https://bing.nxingcloud.co/api/",
        data: `type=json&day=${dayj}`,
        success: function (msg) {
            var imgMsg = $.parseJSON(msg);
            var imgTit = imgMsg["bing_title"];
            var imgDate = imgMsg["submission_date"];
            var imgTitS = imgTit.replace(/\([^\)]*\)/g, ""); //去除括号及空格
            imgTitS = imgTitS.replace(/\s*$/g, "");

            imgTitS = `<span class="badge badge-secondary">${imgDate}</span><br>` + imgTitS;
            // var imgUrlDate = getImgUrlCom(todayTimeEn(i)); //生成com图片url

            $("#pic-js").children().eq(dayj).children("p").empty().append(imgTitS);

            if (dayj > 10) {
                return;
            } else {
                dayj = dayj + 1;
                getText2();
            }
        }
    });
}
getText2();
/* 缩略图文字 （递归优化） end */