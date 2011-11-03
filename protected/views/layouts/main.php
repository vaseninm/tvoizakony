<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />

	<title><?= CHtml::encode($this->pageTitle); ?></title>
        
        <meta charset="utf-8" />
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        
	<link rel="stylesheet" href="/static/css/style.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="/static/css/main.css" type="text/css" media="screen, projection" />
        
	<!--[if lte IE 6]><link rel="stylesheet" href="/static/css/style_ie.css" type="text/css" media="screen, projection" /><![endif]-->
</head>

<body>

<div id="wrapper">

	<header id="header">
		<ul id="menu">
			<li><a href="#">О проекте</a></li>
			<li><a href="#">Новости проекте</a></li>
			<li class="rss"><a href="#">RSS</a></li>
		</ul>
		<ul id="rl" class="fr">
			<li class="login">
                            <? if (Yii::app()->user->isGuest) { ?>
                                <a href="<?= $this->createUrl('/user/login') ?>">Вход для пользователя</a>
                            <? } else { ?>
                                <a href="<?= $this->createUrl('/user/profile') ?>">Ваш профиль</a>
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
					<h1><a href="#" id="logo">Общественный проект "Твои Законы"</a></h1>
					<input type="text" name="search" class="poisk fl" /><input type="submit" value="найти" class="poisk-b" />
					<span class="hint cl">например: <a href="#">оптимизация ресурсов</a></span>
				</div>
	</header><!-- #header-->
 
<?php echo $content; ?>
        
</div><!-- #wrapper -->

<footer id="footer">
	<div class="footer">
		<p class="f-copy fl">&copy; 2011<?= date('Y') == 2011 ? '' : ' - ' . date('Y') ?> Общественный Проект &laquo;Твои Законы&raquo;</p>
		<ul class="f-menu">
			<li><a href="#">О проекте</a></li>
			<li><a href="#">Новости проекте</a></li>
			<li><a href="#">Обратная связь</a></li>
			<li class="rss"><a href="#">RSS</a></li>
		</ul>
	</div>
</footer><!-- #footer -->

</body>
</html>