<script src="/JS/MenuUser.js"></script>
<div class="container-menu-user">
    <span class="container-welcome"><i><?php echo $_SESSION["user"]["login"]; ?></i></span>
    <img class='container-avatar' src='<?php echo isset($_SESSION["user"]["avatar"]) == true ? "/Resources/Images/Upload/" . $_SESSION["user"]["avatar"] : "/Resources/Images/Interface/DefaultAvatar.jpg" ?>'>
    <ul>
        <li onclick='onClickProfile()'><span>Профиль</span></li>
        <li onclick='onClickExit();'><span>Выход</span></li>
    </ul>
</div>