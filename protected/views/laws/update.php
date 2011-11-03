<?php
$this->breadcrumbs=array(
	'Laws'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Laws', 'url'=>array('index')),
	array('label'=>'Create Laws', 'url'=>array('create')),
	array('label'=>'View Laws', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Laws', 'url'=>array('admin')),
);
?>

<h1>Update Laws <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>