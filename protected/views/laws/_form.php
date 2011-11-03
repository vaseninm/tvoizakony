<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'laws-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desc'); ?>
		<?=   $this->widget('application.extensions.cleditor.ECLEditor', array(
        'model'=>$model,
        'attribute'=>'desc', //Model attribute name. Nome do atributo do modelo.
        'options'=>array(
            'width'=>600,
            'height'=>250,
            'useCSS'=>true,
        ),
        'value'=>$model->desc, //If you want pass a value for the widget. I think you will. Se voce precisar passar um valor para o gadget. Eu acho ira.
		));
		?>
		<?php echo $form->error($model,'desc'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->