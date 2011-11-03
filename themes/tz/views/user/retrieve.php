<?php
    $this->pageTitle=Yii::app()->name . ' → Восстановление пароля';
	Yii::app()->breadCrumbs->setCrumb('Восстановление пароля');
?>

<div class="rl">
	<div class="m-title">
		<div class="mt-begin fl"><span>Восстановление пароля</span></div>
		<div class="mt-end fl"><!--&nbsp;--></div>
	</div>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'retrieve-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
            ));
    ?>
    <fieldset>

        <p>
            <label for="email">E-Mail:</label>
            <?php echo $form->textField($model, 'email', array('class' => 'rl-text')); ?>
            <?php echo $form->error($model, 'email'); ?>
        </p>
        <p class="submit_button fl">
            <?php echo CHtml::submitButton('Отправить', array('class' => 'rl-button')); ?>
        </p>
    </fieldset>

    <?php $this->endWidget(); ?>
</div><!-- form -->
