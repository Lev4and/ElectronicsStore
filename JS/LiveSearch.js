$('html').click(function(){
    $('.container-search-result').hide();
});

function onKeyUpInputSearch(inputSearch, event) {
    switch (event.keyCode){
        case 13:
        case 27:
        case 38:
        case 40:{
            break;
        }
        default:{
            let textSearch = $(inputSearch).val();

            const request = getXmlHttp();
            const url = "http://electronicsstore/";
            const params = "action=Поиск&textSearch=" + textSearch;

            var containerSearchResult = $('.container-search-result');

            $(containerSearchResult).show();

            request.open("POST", url, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.addEventListener("readystatechange", () => {
                if(request.readyState === 4 && request.status === 200){
                    containerSearchResult.html("");
                    containerSearchResult.html(request.responseText);

                    console.log(request.responseText);
                }
            });
            request.send(params);

            break;
        }
    }
}

function onKeyDownInputSearch(inputSearch, event){
    switch (event.keyCode){
        case 13:{
            //Enter

            let found = false;
            let searchResultItems = getSearchResultItems();

            for(let i = 0; i < searchResultItems.length; i++){
                if($(searchResultItems[i]).hasClass('active-search-result-item')){
                    found = true;
                    window.location = $($(searchResultItems[i]).find('a')).prop('href');

                    break;
                }
            }

            if(!found){
                window.location = "http://electronicsstore/Views/Pages/SearchResults.php?inputSearch=" + $(inputSearch).val();
            }

            break;
        }
        case 27:{
            //Escape
            let searchResultItems = getSearchResultItems();

            for(let i = 0; i < searchResultItems.length; i++){
                if($(searchResultItems[i]).hasClass('active-search-result-item')){
                    $(searchResultItems[i]).removeClass('active-search-result-item');
                }
            }

            $('.container-search-result').hide();

            break;
        }
        case 38:{
            //Up
            let found = false;
            let given = false;
            let searchResultItems = getSearchResultItems();

            for(let i = searchResultItems.length - 1; i >= 0; i--){
                if(!found){
                    if($(searchResultItems[i]).hasClass('active-search-result-item')){
                        found = true;
                        $(searchResultItems[i]).removeClass('active-search-result-item');
                    }
                }
                else{
                    given = true;
                    $(searchResultItems[i]).addClass('active-search-result-item');

                    break;
                }
            }

            if((!found && !given) || (found && !given)){
                if(searchResultItems.length > 0){
                    $(searchResultItems[searchResultItems.length - 1]).addClass('active-search-result-item');
                }
            }

            break;
        }
        case 40:{
            //Down

            let found = false;
            let given = false;
            let searchResultItems = getSearchResultItems();

            for(let i = 0; i < searchResultItems.length; i++){
                if(!found){
                    if($(searchResultItems[i]).hasClass('active-search-result-item')){
                        found = true;
                        $(searchResultItems[i]).removeClass('active-search-result-item');
                    }
                }
                else{
                    given = true;
                    $(searchResultItems[i]).addClass('active-search-result-item');

                    break;
                }
            }

            if((!found && !given) || (found && !given)){
                if(searchResultItems.length > 0){
                    $(searchResultItems[0]).addClass('active-search-result-item');
                }
            }

            break;
        }
    }
}

function onMouseMoveSearchResultItem(searchResultItem) {
    let searchResultItems = getSearchResultItems();

    for(let i = 0; i < searchResultItems.length; i++){
        if($(searchResultItems[i]).hasClass('active-search-result-item')){
            $(searchResultItems[i]).removeClass('active-search-result-item');
        }
    }

    $(searchResultItem).addClass('active-search-result-item');
}

function onMouseLeaveSearchResultItem(searchResultItem){
    $(searchResultItem).removeClass('active-search-result-item');
}

function getSearchResultItems() {
    return $('.container-search-result').find('.search-result-item');
}

function getActiveSearchResultItems(searchResultItems) {
    $(searchResultItems).find('.search-result-item-active');
}