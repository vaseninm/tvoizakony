<?php
    $this->pageTitle=Yii::app()->name . ' → Регистрация';
	Yii::app()->breadCrumbs->setCrumb('Регистрация');
?>

<div class="rl">
	<div class="m-title">
		<div class="mt-begin fl"><span>Регистрация</span></div>
		<div class="mt-end fl"><!--&nbsp;--></div>
	</div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'edit-form',
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
            <label for="email">E-Mail:</label>
            <?php echo $form->textField($model, 'email', array('class' => 'rl-text')); ?>
            <?php echo $form->error($model, 'email'); ?>
        </p>

        <p>
            <label for="email">Пароль:</label>
            <?php echo $form->passwordField($model, 'password1', array('class' => 'rl-text')); ?>
            <?php echo $form->error($model, 'password1'); ?>
        </p>

        <p>
            <label for="email">Повторите пароль:</label>
            <?php echo $form->passwordField($model, 'password2', array('class' => 'rl-text')); ?>
            <?php echo $form->error($model, 'password2'); ?>
        </p>


        <p>
            <label for="email">Имя:</label>
            <?php echo $form->textField($model, 'firstname', array('class' => 'rl-text')); ?>
            <?php echo $form->error($model, 'firstname'); ?>
        </p>

        <p>
            <label for="email">Фамилия:</label>
            <?php echo $form->textField($model, 'lastname', array('class' => 'rl-text')); ?>
            <?php echo $form->error($model, 'lastname'); ?>
        </p>

        <p class="submit_button fl">
            <?php echo CHtml::submitButton('Отправить', array('class' => 'rl-button')); ?>
        </p>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->


