<?php
$this->breadcrumbs=array(
	'Laws'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Laws', 'url'=>array('index')),
	array('label'=>'Create Laws', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('laws-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление пользователями</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array(
	//'model'=>$model,
//)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'laws-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'username',
		'email',
        array (
			'class' => 'phaSelectColumn',
            'header' => 'Роль',
            'name' => 'role',
            'data' => array(
				'writer' => 'Писатель',
				'politican' => 'Политик',
				'moderator' => 'Модератор',
				'administrator' => 'Администратор',
			),
			'actionUrl' => array('setRole'),
        ),
		'profile.firstname',
		'profile.lastname',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
