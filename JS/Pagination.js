function onClickOpenFirstPage() {
    let paginationItems = getPaginationItems();

    for(let i = 0; i < paginationItems.length; i++){
        setNumberPage(paginationItems[i], i + 1);

        if(i === 0){
            $(paginationItems[i]).addClass('active');
        }
        else{
            $(paginationItems[i]).removeClass('active');
        }
    }

    onChangePage(getNumberPage(getActivePaginationItem(paginationItems)));

}

function onClickOpenBackPage(canChangeActiveNumberPage = true) {
    let paginationItems = getPaginationItems();

    let countItems = paginationItems.length;
    let indexActiveNumberPage = getIndexActivePaginationItem(paginationItems);
    let activeNumberPage = getNumberPage(getActivePaginationItem(paginationItems));

    if(activeNumberPage > 1){
        if(countItems >= 7){
            console.log("IndexActiveNumberPage: " + indexActiveNumberPage + " CountItems: " + countItems + " IndexActiveNumberPage % CountItems = " + indexActiveNumberPage % countItems + " ActiveNumberPage: " + activeNumberPage);
            switch (indexActiveNumberPage + 1){
                case 1:{
                    if(activeNumberPage - 3 > 3){
                        changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage - 1 : activeNumberPage), -3);
                    }
                    else{
                        changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage - 1 : activeNumberPage), 1 - activeNumberPage);
                    }

                    break;
                }
                case 2:{
                    if(activeNumberPage - 2 > 2){
                        changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage - 1 : activeNumberPage), -2);
                    }
                    else{
                        changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage - 1 : activeNumberPage), 0);
                    }

                    break;
                }
                case 3:{
                    if(activeNumberPage - 1 > 2){
                        changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage - 1 : activeNumberPage), -1);
                    }
                    else{
                        changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage - 1 : activeNumberPage), 0);
                    }

                    break;
                }
                default:{
                    changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage - 1 : activeNumberPage), 0);

                    break;
                }
            }
        }
        else{
            changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage - 1 : activeNumberPage), 0);
        }
    }

    onChangePage(getNumberPage(getActivePaginationItem(paginationItems)));
}

function onClickOpenPage(paginationItem, maxCountPages) {
    let paginationItems = getPaginationItems();
    let indexActivePaginationItem = getIndexActivePaginationItem(paginationItems);
    let indexPaginationItem = getIndexPaginationItem(paginationItem, paginationItems);

    setActivePaginationItem(paginationItem, paginationItems);

    if(indexPaginationItem + 1 <= paginationItems.length / 2){
        onClickOpenBackPage(maxCountPages, false);
    }

    if(indexPaginationItem + 1 > paginationItems.length / 2){
        onClickOpenNextPage(maxCountPages, false);
    }

    onChangePage(getNumberPage(paginationItem));
}

function onClickOpenNextPage(maxCountPages, canChangeActiveNumberPage = true) {
    let paginationItems = getPaginationItems();

    let countItems = paginationItems.length;
    let indexActiveNumberPage = getIndexActivePaginationItem(paginationItems);
    let activeNumberPage = getNumberPage(getActivePaginationItem(paginationItems));

    if(activeNumberPage < maxCountPages){
        if(countItems >= 7){
            console.log("IndexActiveNumberPage: " + indexActiveNumberPage + " CountItems: " + countItems + " IndexActiveNumberPage % CountItems = " + indexActiveNumberPage % countItems + " ActiveNumberPage: " + activeNumberPage);
            switch ((indexActiveNumberPage + 1) % countItems){
                case 0:{
                    if(activeNumberPage + 3 < maxCountPages){
                        changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage + 1 : activeNumberPage), 3);
                    }
                    else{
                        changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage + 1 : activeNumberPage), maxCountPages - activeNumberPage);
                    }

                    break;
                }
                case countItems - 1:{
                    if(activeNumberPage + 2 < maxCountPages){
                        changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage + 1 : activeNumberPage), 2);
                    }
                    else{
                        changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage + 1 : activeNumberPage), maxCountPages - 1 - activeNumberPage);
                    }

                    break;
                }
                case countItems - 2:{
                    if(activeNumberPage + 1 < maxCountPages - 1){
                        changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage + 1 : activeNumberPage), 1);
                    }
                    else{
                        changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage + 1 : activeNumberPage), 0);
                    }

                    break;
                }
                default:{
                    changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage + 1 : activeNumberPage), 0);

                    break;
                }
            }
        }
        else{
            changePagination(paginationItems, (canChangeActiveNumberPage === true ? activeNumberPage + 1 : activeNumberPage), 0);
        }
    }

    onChangePage(getNumberPage(getActivePaginationItem(paginationItems)));
}

function onClickOpenLastPage(maxCountPages) {
    let paginationItems = getPaginationItems();

    for(let i = 0; i < paginationItems.length; i++){
        setNumberPage(paginationItems[i], maxCountPages - paginationItems.length + i + 1);

        if(i === paginationItems.length - 1){
            $(paginationItems[i]).addClass('active');
        }
        else{
            $(paginationItems[i]).removeClass('active');
        }
    }

    onChangePage(getNumberPage(getActivePaginationItem(paginationItems)));
}

function getPaginationItems() {
    let paginationBlock = $(document).find('.pagination-block');
    let pagination = $(paginationBlock).find('ul');

    return $(pagination).children('.pagination');
}

function getIndexPaginationItem(paginationItem, paginationItems) {
    let numberPage = getNumberPage(paginationItem);

    for(let i = 0; i < paginationItems.length; i++){
        if(getNumberPage(paginationItems[i]) == numberPage){
            return i;
        }
    }
}

function getIndexActivePaginationItem(paginationItems) {
    for(let i = 0; i < paginationItems.length; i++){
        if($(paginationItems[i]).hasClass('active')){
            return i;
        }
    }
}

function getActivePaginationItem(paginationItems) {
    for(let i = 0; i < paginationItems.length; i++){
        if($(paginationItems[i]).hasClass('active')){
            return paginationItems[i];
        }
    }
}

function getNumberPage(paginationItem) {
    return parseInt($($(paginationItem).find('span')).html());
}

function setActivePaginationItem(paginationItem, paginationItems) {
    for(let i = 0; i < paginationItems.length; i++){
        $(paginationItems[i]).removeClass('active');
    }

    $(paginationItem).addClass('active');
}

function setNumberPage(paginationItem, numberPage) {
    $($(paginationItem).find('span')).html(numberPage);
}

function changePagination(paginationItems, activeNumberPage, delta) {
    for(let i = 0; i < paginationItems.length; i++){
        setNumberPage(paginationItems[i], getNumberPage(paginationItems[i]) + delta);

        if(getNumberPage(paginationItems[i]) === activeNumberPage){
            $(paginationItems[i]).addClass('active');
        }
        else{
            $(paginationItems[i]).removeClass('active');
        }
    }
}

