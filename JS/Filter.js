function onClickOpenCollapsibleBlock(collapsibleBlock) {
    let parent = $(collapsibleBlock).parent();
    let iconCollapse = $(collapsibleBlock).children("div").children("i");
    let collapsibleContent = $(parent).children('.filter-collapsible-content');

    $(iconCollapse).attr({class: "fas fa-chevron-down"});

    $(collapsibleContent).removeAttr("id");
    $(collapsibleBlock).attr({onclick: "onClickCloseCollapsibleBlock(this);"});
}

function onClickCloseCollapsibleBlock(collapsibleBlock) {
    let parent = $(collapsibleBlock).parent();
    let iconCollapse = $(collapsibleBlock).children("div").children("i");
    let collapsibleContent = $(parent).children('.filter-collapsible-content');

    $(iconCollapse).attr({class: "fas fa-chevron-up"});

    $(collapsibleContent).attr({id: "filter-collapsible-content-collapsible"});
    $(collapsibleBlock).attr({onclick: "onClickOpenCollapsibleBlock(this);"});
}

function onClickShowProductsFilterArrowLeft(categorySubcategoryId) {
    onClickCloseFilterArrowLeft();
    onClickApply(categorySubcategoryId);
}

function onClickCloseFilterArrowLeft() {
    let filterArrowLeft = $(document).find('.filter-arrow-left');

    $(filterArrowLeft).css({'display': 'none'});
}

function onCheckedChanged(checkBox, categorySubcategoryId) {
    let filterArrowLeft = $(document).find('.filter-arrow-left');

    let position = $(checkBox).position();
    let parent = $(checkBox).parent('li');

    $(filterArrowLeft).css({'display': 'block', 'top': (position.top - ($(parent).height() / 2)),});

    preApplyFilters(categorySubcategoryId);
    updateCounterProductsFilterArrowLeft();

    updateCountersFilters(categorySubcategoryId);
}

function updateCounterProductsFilterArrowLeft() {
    const request = getXmlHttp();
    const url = "http://electronicsstore/Views/Pages/Customer/Catalog/";
    const params = "action=Обновить предварительный счетчик количества продуктов";

    let filterArrowLeft = $(document).find('.filter-arrow-left');
    let counter = $(filterArrowLeft).find('.filter-arrow-left-content-counter-products');

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

function updateCountersFilters(categorySubcategoryId) {
    let countersManufacturerValue = $('#filtersForm').find('.counter-manufacturer-value');
    let countersCharacteristicQuantityUnitValue = $('#filtersForm').find('.counter-characteristic-quantity-unit-value');

    for (let i = 0; i < countersManufacturerValue.length; i++){
        let parentParent = $($(countersManufacturerValue[i]).parent("span")).parent("li");
        let checkBox = $(parentParent).children('input');
        let mode = $(checkBox).prop('checked') ? "Содержание" : "Добавление";

        console.log("Value: " + $(checkBox).attr('value') + ", Counter: " + $(countersManufacturerValue[i]).html() + ", IsChecked: " + ($(checkBox).prop('checked') ? "Да" : "Нет") + ", Mode: " + mode);

        if(mode ===  "Добавление"){
            $(checkBox).prop('checked', true);

            console.log($(checkBox).prop('checked') ? "Да" : "Нет");
        }

        const request = getXmlHttp();
        const url = "http://electronicsstore/Views/Pages/Customer/Catalog/?action=Получить значение счетчика количества товаров в зависимости от производителя&categorySubcategoryId=" + categorySubcategoryId + "&mode=" + mode + "&manufacturerId=" + $(checkBox).attr('value');

        request.open("POST", url, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.addEventListener("readystatechange", () => {
            if(request.readyState === 4 && request.status === 200){
                if(parseInt(request.responseText) === 0){
                    let parent = $(countersManufacturerValue[i]).parent('span');
                    let parentParent = $(parent).parent('li');

                    let checkBox = $(parentParent).children('input');

                    //$(checkBox).attr('disabled', 'disabled');
                    $(parent).attr('style', 'text-decoration: line-through;');
                }
                else{
                    let parent = $(countersManufacturerValue[i]).parent('span');
                    let parentParent = $(parent).parent('li');

                    let checkBox = $(parentParent).children('input');

                    //$(checkBox).removeAttr('disabled');
                    $(parent).removeAttr('style');
                }

                $(countersManufacturerValue[i]).html("");
                $(countersManufacturerValue[i]).html("(" + request.responseText + ")");

                console.log("Value: " + checkBox.attr('value') + ", NewCounter: " + "(" + request.responseText + ")");
            }
        });
        request.send($("#filtersForm").serialize());

        if(mode ===  "Добавление"){
            $(checkBox).prop('checked', false);
        }
    }

    for (let i = 0; i < countersCharacteristicQuantityUnitValue.length; i++){
        let parentParent = $($(countersCharacteristicQuantityUnitValue[i]).parent("span")).parent("li");
        let checkBox = $(parentParent).children('input');
        let mode = $(checkBox).prop('checked') ? "Содержание" : "Добавление";

        console.log("Value: " + $(checkBox).attr('value') + ", Counter: " + $(countersCharacteristicQuantityUnitValue[i]).html() + ", IsChecked: " + ($(checkBox).prop('checked') ? "Да" : "Нет") + ", Mode: " + mode);

        if(mode ===  "Добавление"){
            $(checkBox).prop('checked', true);

            console.log($(checkBox).prop('checked') ? "Да" : "Нет");
        }

        const request = getXmlHttp();
        const url = "http://electronicsstore/Views/Pages/Customer/Catalog/?action=Получить значение счетчика количества товаров в зависимости от значения характеристики&categorySubcategoryId=" + categorySubcategoryId + "&mode=" + mode + "&characteristicQuantityUnitValueId=" + $(checkBox).attr('value');

        request.open("POST", url, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.addEventListener("readystatechange", () => {
            if(request.readyState === 4 && request.status === 200){
                if(parseInt(request.responseText) === 0){
                    let parent = $(countersCharacteristicQuantityUnitValue[i]).parent('span');
                    let parentParent = $(parent).parent('li');

                    let checkBox = $(parentParent).children('input');

                    //$(checkBox).attr('disabled', 'disabled');
                    $(parent).attr('style', 'text-decoration: line-through;');
                }
                else{
                    let parent = $(countersCharacteristicQuantityUnitValue[i]).parent('span');
                    let parentParent = $(parent).parent('li');

                    let checkBox = $(parentParent).children('input');

                    //$(checkBox).removeAttr('disabled');
                    $(parent).removeAttr('style');
                }

                $(countersCharacteristicQuantityUnitValue[i]).html("");
                $(countersCharacteristicQuantityUnitValue[i]).html("(" + request.responseText + ")");

                console.log("Value: " + checkBox.attr('value') + ", NewCounter: " + "(" + request.responseText + ")");
            }
        });
        request.send($("#filtersForm").serialize());

        if(mode ===  "Добавление"){
            $(checkBox).prop('checked', false);
        }
    }
}