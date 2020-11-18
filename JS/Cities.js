function onChangeSelectedCountries(selectCountries) {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Administrator/City/";
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
