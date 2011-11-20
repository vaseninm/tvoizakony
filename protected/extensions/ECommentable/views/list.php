<?php
/**
 *  @var $this ECommentbleWidget
 *  @var $comments Comments 
 */
?>

<div id="comments">
    <? if (empty($comments)) { ?>
        <h3>Нет комментариев</h3>
    <? } else { ?>
        <h3>Обсуждение</h3>
        <span><?= count($comments) ?> комментария к законопроекту "<?= $owner->title ?>"</span>
        <? foreach ($comments as $comment) { ?>
            <?=
            $this->render('_item', array(
                'comment' => $comment,
            ));
            ?>
    <? } ?>
<? } ?>    
</div>
<p class="add-comment"><a href="#" class="ajax-add-comment" parent="0">Добавить комментарий</a></p>

<div class="ajax-answer-example" style="display: none">
    <?=
    $this->render('_form', array(
        'owner' => $owner,
    ));
    ?>
</div>