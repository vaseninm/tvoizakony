<?php
$level = ($comment->level > 6) ? 6 : $comment->level;
?>
<div class="comment ajax-comment" style="margin-left: <?= 35 * $level ?>px" level="<?= $comment->level ?>" id="comment-<?= $comment->id ?>">
    <? if ($comment->status == Comments::STATUS_DELETE) { ?>
        <p style="color:#b1b7ca; font-style:italic; background:url(http://miron.in/images/crabe.png) no-repeat; padding-left:50px; margin-left: 35px; height: 20px;">Владимир Путин пришел и опубликовал этот комметарий.<p>
    <? } else { ?>
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

        <ul class="fr">
            <? if (Yii::app()->user->checkAccess('writer')) { ?>
                <li><a href="#" parent="<?= ($comment->id) ?>" class="ajax-add-comment">ответить</a></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess('moderator')) { ?>
                <li>
                    <a 
                        href="<?=
                            Yii::app()->urlManager->createUrl('ecomments/delete', array(
                                'modelname' => get_class($owner),
                                'modelid' => $owner->primaryKey,
                            ))
                        ?>" 
                        comment="<?= $comment->id ?>" 
                        class="ajax-delete-comment"
                        >удалить</a>
                </li>
            <? } ?>
        </ul>
    <? } ?>
</div>