function onClickSliderItemProduct(item) {
    $('.overlay').removeAttr("style");
    $('#media-viewer-wrapper-image').attr({src: $(item).attr("src")});
}

function onClickCloseMediaViewer() {
    $('.overlay').attr({style: "display: none;"});
    $('#media-viewer-wrapper-image').removeAttr("src");
}