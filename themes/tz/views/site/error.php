<?php
$this->pageTitle=Yii::app()->name . ' → Ошибка '.$code;
Yii::app()->breadCrumbs->setCrumb('Ошибка ' . $code);
?> 

<div class="cp">
	<div class="m-title">
		<div class="mt-begin fl"><span>Ошибка <?php echo $code; ?></span></div>
		<div class="mt-end fl"><!--&nbsp;--></div>
	</div>
	<p class="m-error"><?php echo CHtml::encode($message); ?></p>
</div>