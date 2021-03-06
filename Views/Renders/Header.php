<script src="/JS/JQuery.js"></script>
<script src="/JS/XmlHttp.js"></script>
<script src="/JS/LiveSearch.js"></script>
<script src="/JS/Login.js"></script>
<script src="/JS/Menu.js"></script>
<script src="/JS/Main.js"></script>
<header>
    <div class="header-top">
        <div class="header-top-location">
            <a><i class="fas fa-map-marker-alt"></i> Челябинск</a>
        </div>
        <div class="header-top-information">
            <ul>
                <li><a href="#"><i class="fas fa-store"></i> Магазины</a></li>
                <li><a href="#"><i class="fas fa-users"></i> Покупателям</a>
                    <ul>
                        <li><a href="#">Доставка</a></li>
                        <li><a href="#">Сервисные центры</a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="fas fa-info-circle"></i> О сайте</a>
            </ul>
        </div>
        <div class="header-top-contacts">
            <div class="header-top-contacts-phone">
                <i class="fas fa-phone-alt"></i> +7 (800) 770-79-98
            </div>
        </div>
    </div>
    <div class="container">
        <div class="container-logo">
            <a href="<?php echo "http://" . $_SERVER["SERVER_NAME"] . "/"; ?>"><img src="/Resources/Images/Icons/Logo.png"></a>
        </div>
        <?php if(!Access::isAdministrator()): ?>
            <div class="container-catalog">
                <button id="catalog" class="container-catalog-button" type="button" onclick="{ openOrCloseMenu('menu-customer'); }">Каталог</button>
            </div>
            <div class="container-search">
                <div class="container-search-input">
                    <input id="inputSearch" type="search" name="inputSearch" placeholder="Поиск по сайту" autocomplete="off"  onkeyup="onKeyUpInputSearch(this, event);" onkeydown="onKeyDownInputSearch(this, event)"/>
                    <div class="container-search-result">

                    </div>
                </div>
                <div class="container-search-button">
                    <i class="fas fa-search" onclick="onClickSearch();"></i>
                </div>
            </div>
            <div class="container-actions">
                <?php if(!isset($_SESSION["user"]["role_name"]) || $_SESSION["user"]["role_name"] == "Покупатель"): ?>
                    <div id="container-action-basket" class="container-action">
                        <a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Basket.php"; ?>"><i class="fas fa-shopping-basket"></i> Корзина <span id="counterBasket"><?php echo count($_SESSION["basket"]); ?></span></a>
                    </div>
                    <!--<div class="container-action">
                        <a><i class="fas fa-heart"></i> Избранное <span>0</span></a>
                    </div>
                    <div class="container-action">
                        <a><i class="far fa-chart-bar"></i> Сравнить <span>0</span></a>
                    </div>-->
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="container-login-or-menu-user">
            <?php if(!isset($_SESSION["user"]) || count($_SESSION["user"]) == 0): ?>
                <div class="container-login">
                    <button class='container-login-button' onclick='onClickLogin();'>Войти</button>
                </div>
            <?php else: ?>
                <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MenuUser.php"; ?>
            <?php endif; ?>
        </div>
    </div>
</header>