<?php
    $this->pageTitle = Yii::app()->name . ' → ' . $model->title;
	Yii::app()->breadCrumbs->setCrumb($model->title);
?>

<? $this->renderPartial('_view', array('data' => $model)) ?>
<div class="text"><p><?= $model->desc ?></p></div>
