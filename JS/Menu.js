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
