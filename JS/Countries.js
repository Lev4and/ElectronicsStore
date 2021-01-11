function onClickApply() {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/Country/?action=Применить";
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

function updateCounterValues() {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/Country/";
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
    const url = "http://electronicsstore/Views/Pages/Administrator/Country/?action=Поменять страницу&numberPage=" + numberPage;

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
    const url = "http://electronicsstore/Views/Pages/Administrator/Country/?action=Обновить нумерацию страниц";

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