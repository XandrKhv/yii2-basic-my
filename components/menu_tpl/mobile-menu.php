<?php
/**
 * Created by PhpStorm.
 * User: XandrKhv
 * Date: 10.01.2019
 * Time: 19:07
 */
?>
<li class="menu-togle">
    <a href="<?= $menu['url'] ?>">
        <?= $menu['name'] ?>
        <?php if(isset($menu['childs'])): ?>
            <span class="caret"></span>
        <?php endif; ?>
    </a>
    <?php if(isset($menu['childs'])): ?>
        <ul class="togle-menu">
            <?= $this->getMenuHtml($menu['childs']) ?>
        </ul>
    <?php endif; ?>
</li>
