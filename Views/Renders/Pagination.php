<div class="pagination-block">
    <ul>
        <li onclick="onClickOpenFirstPage();"><span>❮❮‎</span></li>
        <li onclick="onClickOpenBackPage();"><span>❮</span></li>
        <?php $limit = ceil(count($_SESSION["values"]) / 25) > 8 ? 8 : ceil(count($_SESSION["values"]) / 25); for($i = 1; $i <= $limit; $i++): ?>
            <?php if($i == $_SESSION["pageNumber"]): ?>
                <li class="pagination active" onclick="onClickOpenPage(this, <?php echo ceil(count($_SESSION["values"]) / 25); ?>);"><span><?php echo $i; ?></span></li>
            <?php else: ?>
                <li class="pagination" onclick="onClickOpenPage(this, <?php echo ceil(count($_SESSION["values"]) / 25); ?>);"><span><?php echo $i; ?></span></li>
            <?php endif; ?>
        <?php endfor; ?>
        <li onclick="onClickOpenNextPage(<?php echo ceil(count($_SESSION["values"]) / 25); ?>);"><span>❯</span></li>
        <li onclick="onClickOpenLastPage(<?php echo ceil(count($_SESSION["values"]) / 25); ?>);"><span>❯❯</span></li>
    </ul>
</div>