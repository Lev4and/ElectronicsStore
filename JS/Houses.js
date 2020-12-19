function onChangeSelectedCountries(selectCountries) {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/House/";
    const params = "action=Регионы&countryId=" + selectCountries.value;

    var selectRegions = $('select[name="regionId"]');

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            selectRegions.html("");
            selectRegions.html(request.responseText);

            console.log(request.responseText);
        }
    });
    request.send(params);
}

function onChangeSelectedRegions(selectRegions) {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/House/";
    const params = "action=Города&regionId=" + selectRegions.value;

    var selectCities = $('select[name="cityId"]');

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            selectCities.html("");
            selectCities.html(request.responseText);

            console.log(request.responseText);
        }
    });
    request.send(params);
}

function onChangeSelectedCities(selectCities) {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/House/";
    const params = "action=Улицы&cityId=" + selectCities.value;

    var selectStreets = $('select[name="streetId"]');

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            selectStreets.html("");
            selectStreets.html(request.responseText);

            console.log(request.responseText);
        }
    });
    request.send(params);
}

function onClickApply() {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/House/?action=Применить";
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