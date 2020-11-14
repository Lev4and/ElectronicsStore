<header>
    <div class="header-top">
        <table class="header-top-table" border="0">
            <tr class="header-top-table-tr">
                <td class="header-top-td-location">
                    <div class="header-top-location">
                        <div class="header-top-location-city">
                            <span class="header-top-location-icon"><i class="fas fa-map-marker-alt"></i></span>
                            <a>Челябинск</a>
                        </div>
                    </div>
                </td>
                <td class="header-top-td-information">
                    <div class="header-top-information">
                        <div class="header-top-information-shops">
                            <span class="header-top-information-icon"><i class="fas fa-store"></i></span>
                            <a>Магазины</a>
                        </div>
                        <div class="header-top-information-buyers">
                            <span class="header-top-information-icon"><i class="fas fa-users"></i></span>
                            <a>Покупателям</a>
                        </div>
                        <div class="header-top-information-about-the-site">
                            <span class="header-top-information-icon"><i class="fas fa-info-circle"></i></span>
                            <a>О сайте</a>
                        </div>
                    </div>
                </td>
                <td class="header-top-td-contact-information">
                    <div class="header-top-contact-information">
                        <div class="header-top-contact-information-phone-number">
                            <span class="header-top-information-icon"><i class="fas fa-phone-alt"></i></span>
                            +7 (800) 555-35-35
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="container">
        <table class="container-table" border="0">
            <tr class="container-table-tr">
                <td class="container-table-td-logo">
                    <div class="container-logo">
                        <img src="/Resources/Images/Icons/Logo.png">
                    </div>
                </td>
                <td class="container-table-td-catalog">
                    <form class="container-catalog">
                        <input class="container-catalog-button" type="button" value="Каталог товаров">
                    </form>
                </td>
                <td class="container-table-td-input-search">
                    <div class="container-search">
                        <input class="container-search-input-search" type="search" name="inputSearch" placeholder="Поиск по сайту" />
                        <span class="container-search-icon"><i class="fas fa-search"></i></span>
                    </div>
                </td>
                <td class="container-table-td-buttons">
                    <div class="container-buttons">
                        <div class="container-buttons-basket">
                            <span class="container-buttons-icon"><i class="fas fa-shopping-basket"></i></span>
                            <a>Корзина</a>
                            <span class="container-buttons-count-products-in-basket">0</span>
                        </div>
                    </div>
                </td>
                <td class="container-table-td-login">
                    <div class="container-login">
                        <?php if(!isset($_SESSION["user"]) || count($_SESSION["user"]) == 0){
                            echo "<form action='/Views/Pages/Authorization.html.php' method='post'>";
                            echo "<input class='container-login-button' type='submit' value='Войти'>";
                            echo "</form>";
                        }
                        else{
                            echo "Привет, " . $_SESSION["user"]["login"] . "!";
                        }
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</header>