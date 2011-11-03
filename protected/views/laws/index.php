<?php
$this->breadcrumbs=array(
	'Laws',
);

$this->menu=array(
	array('label'=>'Create Laws', 'url'=>array('create')),
	array('label'=>'Manage Laws', 'url'=>array('admin')),
);
?>

<h1>Laws</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
