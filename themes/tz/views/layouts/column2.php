<?php $this->beginContent('//layouts/main'); ?>


<div id="container">
    <div id="content">
        <?= $content ?>
    </div><!-- #content-->
</div><!-- #container-->

<aside id="sideRight">
    <a href="<?= $this->createUrl('laws/create') ?>"><div class="button">Добавить законопроект</div></a>
    <div class="stat">
        <h3>Навигация</h3>
        <ul class="sidebar">
            <li><a href="<?= $this->createUrl('/laws/index', array('rating' => 0)) ?>">Все законопроекты</a></li>
            <? if (Yii::app()->user->checkAccess('moderator')) { ?>
                <li><a href="<?= $this->createUrl('/laws/index', array('nonapprove' => 1)) ?>">Законопроекты на модерации</a></li>
            <? } ?>
			<? if (!Yii::app()->user->isGuest) { ?>
				<li><a href="<?= $this->createUrl('/laws/index', array('nonapprove' => 1, 'user'=>Yii::app()->user->name)) ?>">Ваши законопроекты ожидающие модерации</a></li>
			<? } ?>
        </ul>
    </div>
    <div class="stat">
        <h3>Статистика</h3>
        <ul class="sidebar">
            <li>Одобренных законопроектов: <?= Laws::model()->cache(30)->count('approve=1'); ?></li>
            <li>Из них на главной: <?= Laws::model()->cache(30)->count('cache_rate >= :rate AND approve=1', array(':rate'=>Laws::MAIN_PAGE_RATE)); ?></li>
            <li>На модерации: <?= Laws::model()->cache(30)->count('approve=0'); ?></li>
            <li>Пользователей: <?= Users::model()->cache(30)->count(); ?></li>
        </ul>
    </div>
</aside><!-- #sideRight -->


<?php $this->endContent(); ?>