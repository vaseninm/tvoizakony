<?php
$this->breadcrumbs=array(
	'Laws'=>array('index'),
	$model->username,
);
?>

<h1><?php echo CHtml::encode($model->profile->lastname); ?> <?php echo CHtml::encode($model->profile->firstname); ?></h1>

<div>
    Ник: <?= CHtml::encode($model->username) ?> 
    <a href="<?php echo $model->profile->bavatar->getFileUrl('large') ?>">
        <img src="<?php echo $model->profile->bavatar->getFileUrl() ?>" alt="<?php echo CHtml::encode($model->profile->lastname); ?> <?php echo CHtml::encode($model->profile->firstname); ?>" />
    </a>
</div>
<div>
    <?php foreach ($model->laws as $law) { ?>
    <div class="view">
	<h2>
            <?php echo CHtml::link(CHtml::encode($law->title), array(
                '/laws/view', 
                'id'=>$law->id,
            )); ?>
        </h2>
        
        Автор: <?= $model->profile->lastname ?> <?= $model->profile->firstname ?>
        <br />
        Рейтинг: <?= $law->rating ?>; <?= CHtml::ajaxLink('+1', array(
            '/laws/plusone', 'law'=>$law->id,
        ), array(
            
        )) ?>
    </div>
    <?php } ?>
</div>
