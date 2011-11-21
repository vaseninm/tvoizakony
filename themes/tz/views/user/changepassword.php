<?php
$this->pageTitle = Yii::app()->name . ' → Изменение пароля';
Yii::app()->breadCrumbs->setCrumb('Изменение пароля');
?>

<div class="rl">
    <div class="m-title">
        <div class="mt-begin fl"><span>Изменение пароля</span></div>
        <div class="mt-end fl"><!--&nbsp;--></div>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'changepassword-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
            ));
    ?>

    <fieldset>

        <p>
            <label for="email">Текущий пароль:</label>
            <?php echo $form->passwordField($model, 'oldpassword', array('class' => 'rl-text')); ?>
            <?php echo $form->error($model, 'oldpassword'); ?>
        </p>

        <p>
            <label for="email">Новый пароль:</label>
            <?php echo $form->passwordField($model, 'password1', array('class' => 'rl-text')); ?>
            <?php echo $form->error($model, 'password1'); ?>
        </p>

        <p>
            <label for="email">Повторите новый пароль:</label>
            <?php echo $form->passwordField($model, 'password2', array('class' => 'rl-text')); ?>
            <?php echo $form->error($model, 'password2'); ?>
        </p>

        <p class="submit_button fl">
            <?php echo CHtml::submitButton('Отправить', array('class' => 'rl-button')); ?>
        </p>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->


