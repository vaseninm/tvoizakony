<?php
    $this->pageTitle=Yii::app()->name . ' → Авторизация';
	Yii::app()->breadCrumbs->setCrumb('Авторизация');
?>

<div class="rl">
	<div class="m-title">
		<div class="mt-begin fl"><span>Авторизация</span></div>
		<div class="mt-end fl"><!--&nbsp;--></div>
	</div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
            ));
    ?>

    <fieldset>

        <p>
            <label for="email">Логин:</label>
            <?php echo $form->textField($model, 'username', array('class' => 'rl-text')); ?>
			
            <?php echo $form->error($model, 'username'); ?>
			
        </p>

        <p>
            <label for="email">Пароль:</label>
            <?php echo $form->passwordField($model, 'password', array('class' => 'rl-text')); ?>
			
            <?php echo $form->error($model, 'password'); ?>
			
        </p>


        <?php echo $form->hiddenField($model, 'rememberMe', array('value'=>1)); ?>

        <p class="submit_button fl">
            <?php echo CHtml::submitButton('Отправить', array('class' => 'rl-button')); ?>
        </p>
        <p class="retrieve">
            <a href="<?= $this->createUrl('/user/retrieve') ?>">Восстановить<br />пароль</a>
        </p>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->


