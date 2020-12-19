function onClickAddToCart(button, productId) {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Customer/Catalog/";
    const params = "action=В корзину&productId=" + productId;

    var counter = $('span[id="counterBasket"]');

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            button.setAttribute("disabled", "disabled");

            counter.html("");
            counter.html(request.responseText);

            console.log(request.responseText);
        }
    });
    request.send(params);
}

function numberItemsChanged() {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Customer/Catalog/?action=Рассчитать стоимость";
    const params = "";

    var totalPayable = $('span[id="totalPayable"]');

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200){
            totalPayable.html("");
            totalPayable.html(request.responseText + " ₽");

            console.log(request.responseText);
        }
    });
    request.send($("#basketForm").serialize());
}
