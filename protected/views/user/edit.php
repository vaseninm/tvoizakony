<?php
$this->pageTitle=Yii::app()->name . ' - Registration';
$this->breadcrumbs=array(
	'Registration',
);
?>

<h1>Login</h1>

<p>Please fill out the following form with your registration:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'edit-form',
	'enableClientValidation'=>true,
    'htmlOptions' => array('enctype'=>'multipart/form-data'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
        
        <div class="row">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname'); ?>
		<?php echo $form->error($model,'firstname'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname'); ?>
		<?php echo $form->error($model,'lastname'); ?>
        </div>

	<div class="row">
		<?php echo $form->labelEx($model,'password1'); ?>
		<?php echo $form->passwordField($model,'password1'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'password2'); ?>
		<?php echo $form->passwordField($model,'password2'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'avatar'); ?>
		<?php echo $form->fileField($model,'avatar'); ?>
		<?php echo $form->error($model,'avatar'); ?>
	</div>
        

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
