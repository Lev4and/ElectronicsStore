let categorySubcategoryId = null;

function init(id) {
    categorySubcategoryId = id;
}

function onClickApply(categorySubcategoryId) {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Customer/Catalog/?categorySubcategoryId=" + categorySubcategoryId;

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


    updateCountersFilters(categorySubcategoryId);
    updateCounterProducts();
    updatePagination();
}

function preApplyFilters(categorySubcategoryId){
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Customer/Catalog/?action=Предварительное применение фильтров&categorySubcategoryId=" + categorySubcategoryId;

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            console.log(request.responseText);
        }
    });
    request.send($("#filtersForm").serialize());
}

function updateCounterProducts() {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Customer/Catalog/";
    const params = "action=Обновить счетчик количества продуктов";

    let counter = $(document).find('#counter-products');

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
    const url = "http://electronicsstore/Views/Pages/Customer/Catalog/?action=Поменять страницу&numberPage=" + numberPage + "&categorySubcategoryId=" + categorySubcategoryId;

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

    updateCounterProducts();
}

function updatePagination() {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Customer/Catalog/?action=Обновить нумерацию страниц";

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
