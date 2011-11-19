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
                <li class="">Рейтинг:</li>
                <? if ($data->isOwner()) { ?>
                    <li class="minus-odin-disabled"></li>
                <? } elseif ($data->isRated() && $data->getVote() > 0) { ?>
                    <li class="minus-odin-disabled"></li>
                <? } elseif ($data->isRated() && $data->getVote() < 0) { ?>
                    <li class="minus-odin-voted"></li>
                <? } else {?>
                    <li class="minus-odin ajax-minus"><a href="<?= $this->createUrl('laws/vote', array('law'=>$data->id)) ?>" do="minus" class="ajax-rate">-1</a></li>
                <? } ?> 
                    
                <li class="ajax-rating"><?= (int) $data->cache_rate ?></li>
                
                <? if ($data->isOwner()) { ?>
                    <li class="plus-odin-disabled"></li>
                <? } elseif ($data->isRated() && $data->getVote() > 0) { ?>
                    <li class="plus-odin-voted"></li>
                <? } elseif ($data->isRated() && $data->getVote() < 0) { ?>
                    <li class="plus-odin-disabled"></li>
                <? } else {?>
                    <li class="plus-odin ajax-plus"><a href="<?= $this->createUrl('laws/vote', array('law'=>$data->id)) ?>" do="plus" class="ajax-rate">+1</a></li>
                <? } ?>
				<? if (isset($isItem)) { ?>
					<li><div style="margin:-5px 0 0 20px;" class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj"></div></li>
				<? } ?>
                <br class="cl" />
            </ul>
        </div>
    </div>
</div>