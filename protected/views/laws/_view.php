<div class="view">
	<h2>
            <?php echo CHtml::link(CHtml::encode($data->title), array(
                '/laws/view', 
                'id'=>$data->id,
            )); ?>
        </h2>
        
        Автор: <?= $data->owner->profile->firstname ?> <?= $data->owner->profile->lastname ?>
        <br />
        Рейтинг: <?= $data->rating ?>; <?= CHtml::ajaxLink('+1', array(
            '/laws/plusone', 'law'=>$data->id,
        ), array(
            
        )) ?>
</div>