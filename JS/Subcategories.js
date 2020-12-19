function onChangeSelectedClassifications(selectClassifications) {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/Subcategory/";
    const params = "action=Категории&classificationId=" + selectClassifications.value;

    var selectCategories = $('select[name="categoryId"]');

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            selectCategories.html("");
            selectCategories.html(request.responseText);

            console.log(request.responseText);
        }
    });
    request.send(params);
}

function onClickApply() {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/Subcategory/?action=Применить";
    const params = "";

    var container = $('div[id="tableBlock"]');

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