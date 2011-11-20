<?php
/**
 *  @var $this ECommentbleWidget
 *  @var $comments Comments 
 */
?>
<div id="respond" class="comments-form ajax-form-after">
    <?= CHtml::beginForm(Yii::app()->urlManager->createUrl('ecomments/add'), 'post', array('class'=>'ajax-comment-form')); ?>
	<fieldset>
	<p><code class="a-tags">Разрешенные теги: &lt;a href=&quot;&quot; title=&quot;&quot;&gt; &lt;abbr title=&quot;&quot;&gt; &lt;acronym title=&quot;&quot;&gt; &lt;b&gt; &lt;blockquote cite=&quot;&quot;&gt; &lt;cite&gt; &lt;code&gt; &lt;del datetime=&quot;&quot;&gt; &lt;em&gt; &lt;i&gt; &lt;q cite=&quot;&quot;&gt; &lt;strike&gt; &lt;strong&gt;</code></p>
		<label>Ваше мнение:</label>
		<?= CHtml::textArea('text'); ?>
		<?= CHtml::hiddenField('parent', 0); ?>
		<?= CHtml::hiddenField('modelname', get_class($owner)); ?>
		<?= CHtml::hiddenField('modelid', $owner->primaryKey); ?>
		<p class="submit_button"><?= CHtml::submitButton('Отправить', array('class'=>'ajax-comment-send rl-button'));?></p>
	</fieldset>
    <?= CHtml::endForm(); ?>
</div>