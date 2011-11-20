<?php
/**
 *  @var $this ECommentbleWidget
 *  @var $comments Comments 
 */
?>
<div class="comments-form ajax-form-after">
    <?= CHtml::beginForm(Yii::app()->urlManager->createUrl('ecomments/add'), 'post', array('class'=>'ajax-comment-form')); ?>

    <?= CHtml::textArea('text'); ?>
    <br />
    <?= CHtml::hiddenField('parent', 0); ?>
    <?= CHtml::hiddenField('modelname', get_class($owner)); ?>
    <?= CHtml::hiddenField('modelid', $owner->primaryKey); ?>
    <?= CHtml::submitButton('Отправить', array('class'=>'ajax-comment-send'));?>

    <?= CHtml::endForm(); ?>
</div>