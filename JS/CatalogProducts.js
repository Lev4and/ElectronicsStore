function onClickApply(categorySubcategoryId) {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Customer/Catalog/";
    const params = "action=Применить&categorySubcategoryId=" + categorySubcategoryId;

    var container = $('div[id="productsBlock"]');

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            container.html("");
            container.html(request.responseText);

            console.log(request.responseText);
        }
    });
    request.send($("#filtersForm").serialize());
}
