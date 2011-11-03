<?php
if (!$isMain) {
	$this->pageTitle = Yii::app()->name . ' → Все законопроекты';
	Yii::app()->breadCrumbs->setCrumb('Все');
} else {
	$this->pageTitle = Yii::app()->name . ' → Лучшие законопроекты';
	Yii::app()->breadCrumbs->setCrumb('Лучшие');
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
		'emptyText'=> '<div class="cp"><div class="m-title"><div class="mt-begin fl"><span>Ошибка</span></div><div class="mt-end fl"><!--&nbsp;--></div></div><p class="m-error">Ничего не найдено.</p></div>',
        'summaryText'=>false,
		'template'=>"{sorter}\n{items}\n{pager}",
		'pager'=>array(
			'header'=>'',
			'cssFile'=>false,
			//'pages'=>array(
				//'class'=>'CPagination',
				//'params'=> $isMain ? array('rating'=>10) : null,
			//),
			//'nextPageLabel'=>false,
			//'prevPageLabel'=>false,
		),
)); ?>
