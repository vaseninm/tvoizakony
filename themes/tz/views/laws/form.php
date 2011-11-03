<?php
    $this->pageTitle = 
            Yii::app()->name . ' → '; 
    $this->pageTitle .= $model->isNewRecord ? 'Добавление законопроекта' : 'Редактирование "' . $model->title . '"';
	Yii::app()->breadCrumbs->setCrumb($model->isNewRecord ? 'Добавление законопроекта' : 'Редактирование "' . $model->title . '"');
?>

<div class="cp">
    <div class="m-title">
		<div class="mt-begin fl"><span><?= $model->isNewRecord ? "Добавить" : "Редактировать" ?> законопроект</span></div>
		<div class="mt-end fl"><!--&nbsp;--></div>
	</div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'laws-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
            ));
    ?>

    <fieldset>
        <p>
            <label for="email">Заголовок:</label>
            <?php echo $form->textField($model, 'title', array('class' => 'cp-text')); ?>
            <?php echo $form->error($model, 'title'); ?>
        </p>

        <p>
            <label for="email">Описание:</label>

<?php
    $this->widget('application.extensions.cleditor.ECLEditor', array(
        'model'=>$model,
        'attribute'=>'desc', //Model attribute name. Nome do atributo do modelo.
        'options'=>array(
            'width'=>'600',
            'height'=>250,
            'useCSS'=>false,
        ),
        'value'=>$model->desc, //If you want pass a value for the widget. I think you will. Se você precisar passar um valor para o gadget. Eu acho irá.
    ));
?>
			
            <?php echo $form->error($model, 'desc'); ?>
        </p>

        <p class="submit_button fl">
            <?php echo CHtml::submitButton('Отправить', array('class' => 'rl-button')); ?>
        </p>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->
