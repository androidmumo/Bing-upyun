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

/* 生成轮播图文字并插入 */
for (let i = 0; i < 3; i++) {
    var carouselStr = "";
    var imgMsg = getImgMsg(i);
    var imgTit = imgMsg["bing_title"];
    var imgTitS = imgTit.replace(/\([^\)]*\)/g, ""); //去除括号及空格
    imgTitS = imgTitS.replace(/\s*$/g, "");

    // var imgUrlDate = getImgUrlHd(todayTimeEn(i)); //生成HD图片url

    carouselStr = `
            <h5>${imgTitS}</h5>
            <p>${imgTit}</p>
    `
    $(".carousel-caption").eq(i).empty().append(carouselStr);
}
/* 生成轮播图文字并插入 end */

/* 生成缩略图文字并插入 */
for (let i = 0; i < 12; i++) {
    var imgMsg = getImgMsg(i);
    var imgTit = imgMsg["bing_title"];
    var imgDate = imgMsg["submission_date"];
    var imgTitS = imgTit.replace(/\([^\)]*\)/g, ""); //去除括号及空格
    imgTitS = imgTitS.replace(/\s*$/g, "");

    imgTitS = `<span class="badge badge-secondary">${imgDate}</span><br>`+ imgTitS;
    // var imgUrlDate = getImgUrlCom(todayTimeEn(i)); //生成com图片url

    $("#pic-js").children().eq(i).children("p").empty().append(imgTitS);
}
/* 生成缩略图文字并插入 end */