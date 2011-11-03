<?php
    $this->pageTitle=Yii::app()->name . ' → Редактирование профиля';
	Yii::app()->breadCrumbs->setCrumb('Редактирование профиля');
?>

<div class="rl">
	<div class="m-title">
		<div class="mt-begin fl"><span>Редактирование профиля</span></div>
		<div class="mt-end fl"><!--&nbsp;--></div>
	</div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'edit-form',
        'enableClientValidation' => true,
		'htmlOptions' => array('enctype'=>'multipart/form-data'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
            ));
    ?>

    <fieldset>
        <p>
            <label for="email">Имя*:</label>
            <?php echo $form->textField($model, 'firstname', array('class' => 'rl-text')); ?>
            <?php echo $form->error($model, 'firstname'); ?>
        </p>

        <p>
            <label for="email">Фамилия*:</label>
            <?php echo $form->textField($model, 'lastname', array('class' => 'rl-text')); ?>
            <?php echo $form->error($model, 'lastname'); ?>
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
            <label for="email">Фото:</label>
            <?php echo $form->fileField($model, 'avatar', array('class' => 'rl-text')); ?>
            <?php echo $form->error($model, 'avatar'); ?>
        </p>


        <p class="submit_button fl">
            <?php echo CHtml::submitButton('Отправить', array('class' => 'rl-button')); ?>
        </p>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->


