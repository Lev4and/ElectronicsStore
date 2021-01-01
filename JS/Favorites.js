function onMouseMoveFavoriteButton(button, isFavorite) {
    if(isFavorite){
        $(button).children("i").attr({class: "far fa-heart"});
    }
    else{
        $(button).children("i").attr({class: "fas fa-heart"});
    }
}

function onMouseLeaveFavoriteButton(button, isFavorite) {
    if(isFavorite){
        $(button).children("i").attr({class: "fas fa-heart"});
    }
    else{
        $(button).children("i").attr({class: "far fa-heart"});
    }
}

function onClickFavoriteButton(button, isFavorite, productId, userId) {
    if(isFavorite){
        const request = getXmlHttp();
        const url = "http://electronicsstore/Views/Pages/Customer/Catalog/";
        const params = "action=Не нравиться&productId=" + productId + "&userId=" + userId;

        let counterIconId = "count-of-likes-icon-" + productId;
        let counterId = "count-of-likes-" + productId;
        let counterIcon = $("#" + counterIconId);
        let counter = $("#" + counterId);

        request.open("POST", url, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.addEventListener("readystatechange", () => {
            if(request.readyState === 4 && request.status === 200){
                $(button).children("i").attr({class: "far fa-heart"});

                $(button).attr({onmousemove: "onMouseMoveFavoriteButton(this, false)"});
                $(button).attr({onmouseleave: "onMouseLeaveFavoriteButton(this, false)"});
                $(button).attr({onclick: "onClickFavoriteButton(this, false, " + productId + ", " + userId + ")" });

                console.log(counterId);

                counter.html("");
                counter.html(request.responseText);

                counterIcon.attr({style: "color:black"});

                console.log(request.responseText);
            }
        });
        request.send(params);
    }
    else{
        const request = getXmlHttp();
        const url = "http://electronicsstore/Views/Pages/Customer/Catalog/";
        const params = "action=Нравиться&productId=" + productId + "&userId=" + userId;

        let counterIconId = "count-of-likes-icon-" + productId;
        let counterId = "count-of-likes-" + productId;
        let counterIcon = $("#" + counterIconId);
        let counter = $("#" + counterId);

        request.open("POST", url, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.addEventListener("readystatechange", () => {
            if(request.readyState === 4 && request.status === 200){
                $(button).children("i").attr({class: "fas fa-heart"});

                $(button).attr({onmousemove: "onMouseMoveFavoriteButton(this, true)"});
                $(button).attr({onmouseleave: "onMouseLeaveFavoriteButton(this, true)"});
                $(button).attr({onclick: "onClickFavoriteButton(this, true, " + productId + ", " + userId + ")" });

                counter.html("");
                counter.html(request.responseText);

                counterIcon.attr({style: "color:red"});

                console.log(request.responseText);
            }
        });
        request.send(params);
    }
}