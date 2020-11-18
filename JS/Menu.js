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
