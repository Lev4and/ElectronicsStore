<script src="/JS/MenuUser.js"></script>
<div class="container-menu-user">
    <span class="container-welcome"><i><?php echo "Привет, " . $_SESSION["user"]["login"] . "!"; ?></i></span>
    <img class='container-avatar' src='<?php echo isset($_SESSION["user"]["avatar"]) == true ? "/Resources/Images/Upload/" . $_SESSION["user"]["avatar"] : "/Resources/Images/Interface/DefaultAvatar.jpg" ?>'>
    <ul>
        <li onclick='onClickProfile()'>Профиль</li>
        <li onclick='onClickExit();'>Выход</li>
    </ul>
</div>