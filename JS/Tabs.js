function onClickTab(tabBlock, tabName, productId) {
    $('.product-block-tabs').children("div").removeAttr("id");
    $(tabBlock).attr("id", "product-block-tab-active");

    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/Product/";
    const params = "action=Содержимое вкладки&tabName=" + tabName + "&productId=" + productId;

    let container = $('.product-block-tab-content');

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            container.html("");
            container.html(request.responseText);

            console.log(request.responseText);
        }
    });
    request.send(params);
}