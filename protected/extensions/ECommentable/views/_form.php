<?php
/**
 *  @var $this ECommentbleWidget
 *  @var $comments Comments 
 */
?>
<div id="respond" class="comments-form ajax-form-after">
    <?= CHtml::beginForm(Yii::app()->urlManager->createUrl('ecomments/add'), 'post', array('class'=>'ajax-comment-form')); ?>
	<fieldset>
	<div>
            <code class="a-tags">
                <a href="#" class="ajax-tags">Разрешенные теги:</a>
                <p class="ajax-tags" style="display:none"> &lt;a href=&quot;&quot; title=&quot;&quot;&gt; &lt;blockquote cite=&quot;&quot;&gt; &lt;b&gt; &lt;i&gt; &lt;s&gt;</p>
            </code>
        </div>
		<label>Ваше мнение:</label>
		<?= CHtml::textArea('text'); ?>
		<?= CHtml::hiddenField('parent', 0); ?>
		<?= CHtml::hiddenField('modelname', get_class($owner)); ?>
		<?= CHtml::hiddenField('modelid', $owner->primaryKey); ?>
		<ul>
			<li class="submit_button"><?= CHtml::submitButton('Отправить', array('class'=>'ajax-comment-send rl-button'));?></li>
			<li><?= CHtml::button('Отмена', array('class'=>'ajax-comment-cancel rl-button'));?></li>
		</ul>
	</fieldset>
    <?= CHtml::endForm(); ?>
</div>