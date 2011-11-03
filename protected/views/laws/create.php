<?php
$this->breadcrumbs=array(
	'Laws'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Laws', 'url'=>array('index')),
	array('label'=>'Manage Laws', 'url'=>array('admin')),
);
?>

<h1>Create Laws</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>