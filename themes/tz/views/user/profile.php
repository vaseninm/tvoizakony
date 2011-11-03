<?php
$this->pageTitle = Yii::app()->name . ' → ';
$this->pageTitle .= ($model->id == Yii::app()->user->id) ? 'Мой профиль' : 'Профиль ' . CDeclination::get(CHtml::encode($model->profile->lastname . ' ' . $model->profile->firstname), CDeclination::VIN);
Yii::app()->breadCrumbs->setCrumb(($model->id == Yii::app()->user->id) ? 'Мой профиль' : 'Профиль ' . CDeclination::get(CHtml::encode($model->profile->lastname . ' ' . $model->profile->firstname), CDeclination::VIN));

$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target'=>'a[rel=gallery]',
    'config'=>array(),
    )
);
?>

<div class="cp">
    <div class="m-title">
        <div class="mt-begin fl"><span>
                <? if ($model->id == Yii::app()->user->id) { ?>
                    Мой профиль
                <? } else { ?>
                    Профиль <?= CDeclination::get(CHtml::encode($model->profile->lastname . ' ' . $model->profile->firstname), CDeclination::VIN); ?>
                <? } ?>
            </span></div>
        <div class="mt-end fl"><!--&nbsp;--></div>
    </div>
    <div class="profile">
        <div class="avatarko">
            <a href="<?php echo $model->profile->bavatar->getFileUrl('large') ?>" rel="gallery">
                <img
                    src="<?php echo $model->profile->bavatar->getFileUrl() ?>"
                    alt="<?php echo CHtml::encode($model->profile->lastname); ?> <?php echo CHtml::encode($model->profile->firstname); ?>"
                    title="<?php echo CHtml::encode($model->profile->lastname); ?> <?php echo CHtml::encode($model->profile->firstname); ?>"

                    />
            </a>
        </div>
        <ul class="listing">
            <li>Имя: <?php echo CHtml::encode($model->profile->firstname); ?></li>
            <li>Фамилия: <?php echo CHtml::encode($model->profile->lastname); ?></li>
            <li>Никнейм: <?php echo CHtml::encode($model->username); ?></li>
            <!--<li>Twitter: <a href="#">@navalny</a></li>-->
            <li>Законопроектов: 
                <a href="<?= $this->createUrl('/laws/index', array('user'=>$model->username, 'rating' => 0)) ?>">
                    <?= Laws::model()->count('approve=1 AND user_id = :user', array(':user'=>$model->id)); ?></a>, 
                из них на главной 
                <a href="<?= $this->createUrl('/laws/index', array('user'=>$model->username)) ?>">
                    <?= Laws::model()->count('approve=1 AND cache_rate >= :rate AND user_id = :user', 
                            array(':rate'=>Laws::MAIN_PAGE_RATE, ':user'=>$model->id)
                    ); ?>
                </a>
            </li>
        </ul>
    </div>
    <div class="m-title">
        <div class="mt-begin fl"><span>Мои законопроекты</span></div>
        <div class="mt-end fl"><!--&nbsp;--></div>
    </div>
    <?php foreach ($model->laws as $key => $law) { ?>
        <?php //if ($key > 9) break; ?>
        <div class="mzakony">
            <h2><a href="<?= $this->createUrl('/laws/view', array('id' => $law->id)) ?>"><?= CHtml::encode($law->title) ?></a></h2>
            <? if ($law->owner->id == Yii::app()->user->id || Yii::app()->user->checkAccess('moderator')) { ?>
			<ul class="m-edit">
                <li class="edit"><a href="<?= $this->createUrl('/laws/update', array('id' => $law->id)) ?>">Редактировать</a></li>
                <li class="delete"><a href="<?= $this->createUrl('/laws/delete', array('id' => $law->id)) ?>">Удалить</a></li>
            </ul>
			<? } ?>
            <hr />
        </div>
<?php } ?>
</div>
