<?php if(isset($_SESSION["error"]) && iconv_strlen($_SESSION["error"], "UTF-8") > 0): ?>
<div class="error-block">
    <h1 class="error-message-block">Ошибка! Причина: <?php echo $_SESSION["error"]; ?></h1>
</div>
<?php endif; ?>