var onOpened = false;

function openOrCloseMenu(elementId) {
    if(onOpened){
        closeMenu(elementId);
        onOpened = false;
    }
    else {
        openMenu(elementId);
        onOpened = true;
    }
}

function openMenu(elementId) {
    document.getElementById(elementId).setAttribute('style', 'visibility: visible');
}

function closeMenu(elementId) {
    document.getElementById(elementId).setAttribute('style', 'visibility: hidden');
}

function onClickCountries() {
    window.location = "http://electronicsstore/Views/Pages/Administrator/Country/";
}

function onClickRegions() {
    window.location = "http://electronicsstore/Views/Pages/Administrator/Region/";
}

function onClickCities() {
    window.location = "http://electronicsstore/Views/Pages/Administrator/City/";
}

function onClickStreets() {
    window.location = "http://electronicsstore/Views/Pages/Administrator/Street/";
}

function onClickHouses() {
    window.location = "http://electronicsstore/Views/Pages/Administrator/House/";
}

function onClickClassifications() {
    window.location = "http://electronicsstore/Views/Pages/Administrator/Classification/";
}

function onClickCategories() {
    window.location = "http://electronicsstore/Views/Pages/Administrator/Category/";
}

function onClickSubcategories() {
    window.location = "http://electronicsstore/Views/Pages/Administrator/Subcategory/";
}
