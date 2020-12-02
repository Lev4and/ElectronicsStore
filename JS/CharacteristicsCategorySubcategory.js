function onChangeSelectedClassifications(selectClassifications) {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/CharacteristicCategorySubcategory/";
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

function onChangeSelectedCategories(selectCategories) {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/CharacteristicCategorySubcategory/";
    const params = "action=Подкатегории&categoryId=" + selectCategories.value;

    var selectSubcategories = $('select[name="subcategoryId"]');

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            selectSubcategories.html("");
            selectSubcategories.html(request.responseText);

            console.log(request.responseText);
        }
    });
    request.send(params);
}

function onChangeSelectedSubcategories(selectSubcategories) {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/CharacteristicCategorySubcategory/";
    const params = "action=КатегорииПодкатегории&subcategoryId=" + selectSubcategories.value;

    var selectCategoriesSubcategory = $('select[name="categorySubcategoryId"]');

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            selectCategoriesSubcategory.html("");
            selectCategoriesSubcategory.html(request.responseText);

            console.log(request.responseText);
        }
    });
    request.send(params);
}
