<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="ru" />

        <title><?= CHtml::encode($this->pageTitle); ?></title>

        <meta charset="utf-8" />
        <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

        <link rel="stylesheet" href="<?= Yii::app()->theme->baseUrl ?>/static/css/style.css" type="text/css" media="screen, projection" />
        <link rel="stylesheet" href="<?= Yii::app()->theme->baseUrl ?>/static/css/main.css" type="text/css" media="screen, projection" />

		<!--[if lte IE 6]><link rel="stylesheet" href="<?= Yii::app()->theme->baseUrl ?>/static/css/style_ie.css" type="text/css" media="screen, projection" /><![endif]-->
		<script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>
		<?$this->widget('ext.googleAnalytics.EGoogleAnalyticsWidget',
			array('account'=>'UA-9356976-6','domainName'=>'.tvoizakony.ru')
		);?>
    </head>

    <body>
		<? $this->widget('ext.EUserFlash', array(
			'initScript'=>'$(".userflash").hide().slideDown("slow").delay(3000).slideUp("slow");',
		)); ?>
		<div class="flash-box" id="ajax-rating-non-reg" style="display:none";>
			<div class="flash-box-content">
				<h3>Извините, но голосовать могут только зарегистрированные пользователи.</h3>
				<p>Если вы уже зарегистрированы, можете пройти <a href="<?= $this->createUrl('/user/login') ?>">авторизацию</a> или же предлагаем вам <a href="<?= $this->createUrl('/user/registration') ?>">зарегистрироваться</a>.</p>
				<div class="flash-box-close" id="ajax-rating-non-reg-close">Закрыть</div>
			</div>
		</div>
        <div id="wrapper">

            <header id="header">
                <ul id="hl-menu">
                    <li><a href="<?= $this->createUrl('/site/page', array('view'=>'about')) ?>">О проекте</a></li>
                    <li><a href="http://twitter.com/tvoizakony">Новости проекта</a></li>
                    <!--<li class="rss"><a href="#">RSS</a></li>-->
                </ul>
                <ul id="hr-menu" class="fr">
                    <li class="login">
                        <? if (Yii::app()->user->isGuest) { ?>
                            <a href="<?= $this->createUrl('/user/login') ?>">Вход для пользователя</a>
                        <? } else { ?>
                            <a href="<?= $this->createUrl('/user/profile') ?>">Ваш профиль</a> 
                            <a href="<?= $this->createUrl('/user/edit') ?>">(ред.)</a>
                        <? } ?>
                    </li>
                    <li class="reg">
                        <? if (Yii::app()->user->isGuest) { ?>
                            <a href="<?= $this->createUrl('/user/registration') ?>">Регистрация</a>
                        <? } else { ?>
                            <a href="<?= $this->createUrl('/user/logout') ?>">Выход</a>
                        <? } ?>
                    </li>
                </ul>
                <div class="cl"><!--&nbsp;--></div>
                <div class="p-frame">
                    <h1><a href="/" id="logo">Общественный проект "Твои Законы"</a></h1>
					<form action="<?= $this->createUrl('/laws/index', array('rating'=>0)) ?>" method="post">
						<input type="text" name="search" class="poisk fl" value="<?= isset($_POST['search']) ? $_POST['search'] : '' ?>" id="ajax-search" /><input type="submit" value="найти" class="poisk-b" />
						<span class="hint cl">например: <a href="#" id="ajax-search-hint">расширение производства</a></span>
					</form>
                </div>
            </header><!-- #header-->
            <section id="middle">
				<? Yii::app()->breadCrumbs->render(); ?>
                <?= $content; ?>
            </section><!-- #middle-->
        </div><!-- #wrapper -->

        <footer id="footer">
            <div class="footer">
                <p class="f-copy fl">&copy; 2011<?= date('Y') == 2011 ? '' : ' - ' . date('Y') ?> Общественный Проект &laquo;Твои Законы&raquo;</p>
                <ul class="f-menu">
                    <li><a href="<?= $this->createUrl('/site/page', array('view'=>'about')) ?>">О проекте</a></li>
					<li><a href="<?= $this->createUrl('/site/page', array('view'=>'todo')) ?>">Запланировано</a></li>
                    <li><a href="http://twitter.com/tvoizakony">Новости проекта</a></li>
                    <li><a href="mailto:a@tvoizakony.ru">Обратная связь</a></li>
                    <!--<li class="rss"><a href="#">RSS</a></li>-->
                </ul>
            </div>
        </footer><!-- #footer -->	

    </body>
</html>