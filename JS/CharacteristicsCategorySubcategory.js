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

function onChangeSelectedCategoriesSubcategory(selectCategoriesSubcategory) {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/CharacteristicCategorySubcategory/";
    const params = "action=РазделыХарактеристикиКатегорииПодкатегории&categorySubcategoryId=" + selectCategoriesSubcategory.value;

    var selectSectionsCategorySubcategory = $('select[name="sectionCategorySubcategoryId"]');

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            selectSectionsCategorySubcategory.html("");
            selectSectionsCategorySubcategory.html(request.responseText);

            console.log(request.responseText);
        }
    });
    request.send(params);
}

function onClickApply() {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/CharacteristicCategorySubcategory/?action=Применить";
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

    updateCounterValues();
    updatePagination();
}

function onSelectedChanged(select) {
    let filterArrowLeft = $(document).find('.filter-arrow-left');

    let position = $(select).position();
    let parent = $(select).parent('div');

    $(filterArrowLeft).css({'display': 'block', 'top': ($(parent).position().top - ($(parent).height() / 6))});

    preApplyFilters();
    updateCounterValuesFilterArrowLeft();
}

function onClickShowValuesFilterArrowLeft() {
    onClickCloseFilterArrowLeft();
    onClickApply();
}

function preApplyFilters(){
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/CharacteristicCategorySubcategory/?action=Предварительное применение фильтров";

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            console.log(request.responseText);
        }
    });
    request.send($("#filtersForm").serialize());
}

function updateCounterValuesFilterArrowLeft() {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/CharacteristicCategorySubcategory/";
    const params = "action=Обновить предварительный счетчик количества записей";

    let filterArrowLeft = $(document).find('.filter-arrow-left');
    let counter = $(filterArrowLeft).find('.filter-arrow-left-content-counter-values');

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            counter.html("");
            counter.html(request.responseText);

            console.log(request.responseText);
        }
    });
    request.send(params);
}

function updateCounterValues() {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/CharacteristicCategorySubcategory/";
    const params = "action=Обновить счетчик количества записей";

    let counter = $(document).find('#counter-values');

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            counter.html("");
            counter.html(request.responseText);

            console.log(request.responseText);
        }
    });
    request.send(params);
}

function onChangePage(numberPage) {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/CharacteristicCategorySubcategory/?action=Поменять страницу&numberPage=" + numberPage;

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

    updateCounterValues();
}

function updatePagination() {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/CharacteristicCategorySubcategory/?action=Обновить нумерацию страниц";

    var pagination = $('.pagination');

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            pagination.html("");
            pagination.html(request.responseText);

            console.log(request.responseText);
        }
    });
    request.send();
}
