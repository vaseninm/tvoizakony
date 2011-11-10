<div class="post ajax-post" id="ajax-law-<?= $data->id ?>">
    <a href="https://twitter.com/intent/tweet?text=<?= urlencode(CHtml::encode($data->title) . " via @tvoizakony") ?>&amp;url=<?= urlencode($this->createAbsoluteUrl('/laws/view', array('id' => $data->id))); ?>" class="twitter fl">Отправить в Twitter</a>
    <div class="in-post">
        <h2 class="p-title">
            <a href="<?= $this->createUrl('/laws/view', array('id' => $data->id)); ?>">
                <?= CHtml::encode($data->title) ?>
            </a>
        </h2>
        <div class="avatarko-thumb fl">
            <img
                src="<?= $data->owner->profile->bavatar->getFileUrl('thumb') ?>"
                title="<?= CHtml::encode($data->owner->profile->lastname) ?> <?= CHtml::encode($data->owner->profile->firstname) ?>" 
                alt="<?= CHtml::encode($data->owner->profile->lastname) ?> <?= CHtml::encode($data->owner->profile->firstname) ?>" 
                />
        </div>
        <div class="">
            <ul class="m-edit p-author">
                <li>
                    Автор: 
                    <a href="<?= $this->createUrl('user/profile', array('username' => CHtml::encode($data->owner->username))) ?>">
                        <?= CHtml::encode($data->owner->profile->lastname) ?> <?= CHtml::encode($data->owner->profile->firstname) ?>
                    </a>
                </li>
                <li>Добавлено: <a href="#"><?= date('d.m.Y', $data->createtime); ?></a></li>
                <? if ($data->isEdited()) { ?>
                    <li class="edit"><a href="<?= $this->createUrl('/laws/update', array('id' => $data->id)) ?>">Редактировать</a></li>
                    <li class="delete"><a class="ajax-delete" href="<?= $this->createUrl('/laws/delete', array('id' => $data->id)) ?>">Удалить</a></li>
                <? } ?>
                <? if (Yii::app()->user->checkAccess('moderator')) { ?>
                    <li class="decline"<? if (!$data->approve) { ?> style="display:none;"<? } ?>>
                        <a href="<?= $this->createUrl('/laws/setstatus', array('law' => $data->id, 'status' => 0)) ?>" class="ajax-setstatus-1">Отправить на модерацию</a>
                    </li>
                    <li class="approve" <? if ($data->approve) { ?> style="display:none;"<? } ?>>
                        <a href="<?= $this->createUrl('/laws/setstatus', array('law' => $data->id, 'status' => 1)) ?>" class="ajax-setstatus-0">Утвердить проект</a>
                    </li>
                <? } ?>
            </ul>
            <ul class="p-rating">	
                <? if ($data->isOwner()) { ?>
                    //свой закон
                <? } elseif ($data->isRated() && $data->getVote() > 0) { ?>
                    //голосовал за
                <? } elseif ($data->isRated() && $data->getVote() < 0) { ?>
                    //голосовал против
                <? } else {?>
                    //не голосовал, закон чужой
                <? } ?>
                
                <? if ($data->isRated()) { ?>
                    <li class="plus-odin-voted ajax-vote"></li>
                <? } elseif ($data->owner->id == Yii::app()->user->id) { ?>
                    <li class="plus-odin-disabled ajax-vote"></li>
                <? } else { ?>
                    <li class="plus-odin ajax-vote">
                        <a href="<?= $this->createUrl('laws/plusone', array('law' => $data->id)); ?>" class="ajax-do-vote" do="minus">-1</a>
                    </li>		
                <? } ?>
                <li class="">Рейтинг: <span class="ajax-rating"><?= (int) $data->cache_rate ?></span></li>
                <? if ($data->isRated()) { ?>
                    <li class="plus-odin-voted ajax-vote"></li>
                <? } elseif ($data->owner->id == Yii::app()->user->id) { ?>
                    <li class="plus-odin-disabled ajax-vote"></li>
                <? } else { ?>
                    <li class="plus-odin ajax-vote">
                        <a href="<?= $this->createUrl('laws/plusone', array('law' => $data->id)); ?>" class="ajax-do-vote" do="plus">+1</a>
                    </li>		
                <? } ?>
                <br class="cl" />
            </ul>
        </div>
    </div>
</div>