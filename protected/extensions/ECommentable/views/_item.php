<?php
$level = ($comment->level > 6) ? 6 : $comment->level;
?>
<div class="comment" style="margin-left: <?= 35 * $level ?>px">
    <img
        src="<?= $comment->owner->profile->bavatar->getFileUrl('thumb') ?>"
        title="<?= CHtml::encode($comment->owner->profile->lastname) ?> <?= CHtml::encode($comment->owner->profile->firstname) ?>" 
        alt="<?= CHtml::encode($comment->owner->profile->lastname) ?> <?= CHtml::encode($comment->owner->profile->firstname) ?>" 
        class="gravatar fl"
        />

    <div class="comment-info">
        <a href="<?= Yii::app()->urlManager->createUrl('user/profile', array('username' => CHtml::encode($comment->owner->username))) ?>"><?= CHtml::encode($comment->owner->profile->lastname) ?> <?= CHtml::encode($comment->owner->profile->firstname) ?></a>
        <span class="date"><?= date('d.m.Y @ H:i', $comment->createtime); ?></span>
        <div class="comment-text">
            <p><?= $comment->text ?></p>
        </div>
    </div>

    <ul class="fr"><li><a href="#" parent="<?= ($comment->id) ?>" class="ajax-add-comment">ответить</a></li><li><a href="#">редактировать</a></li><li><a href="#">удалить</a></li></ul>
</div>