<?php
$this->breadcrumbs=array(
	'Laws'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Laws', 'url'=>array('index')),
	array('label'=>'Create Laws', 'url'=>array('create')),
	array('label'=>'Update Laws', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Laws', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Laws', 'url'=>array('admin')),
);
?>

<h1><?php echo CHtml::encode($model->title); ?></h1>

<div>
    <?= nl2br($model->desc, true); ?>
    <br/>
        Автор: <?= $model->owner->profile->firstname ?> <?= $model->owner->profile->lastname ?>
        <br />
        Рейтинг: <?= $model->rating ?>; <?= CHtml::ajaxLink('+1', array(
            '/laws/plusone', 'law'=>$model->id,
        ), array(
            
        )) ?>
</div>