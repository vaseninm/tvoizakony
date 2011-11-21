<?php
/**
 *  @var $this ECommentbleWidget
 *  @var $comments Comments 
 */
?>

<div id="comments" class="ajax-comments">
    <? if (empty($comments)) { ?>
        <h3>Нет комментариев</h3>
    <? } else { ?>
        <h3>Обсуждение</h3>
        <span><empty class="ajax-comments-count"><?= count($comments) ?></empty> комментария к законопроекту "<?= $owner->title ?>"</span>
        <? foreach ($comments as $comment) { ?>
            <?=
            $this->render('_item', array(
                'comment' => $comment,
                'owner' => $owner,
            ));
            ?>
    <? } ?>
<? } ?>    
</div>
<? if(Yii::app()->user->checkAccess('writer')) { ?>
<p class="add-comment"><a href="#" class="ajax-add-comment ajax-add-comment-not-parent" parent="0">Добавить комментарий</a></p>

<div class="ajax-answer-example" style="display: none">
    <?=
    $this->render('_form', array(
        'owner' => $owner,
    ));
    ?>
</div>
<? } ?>