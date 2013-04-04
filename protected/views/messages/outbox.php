<?php
$this->breadcrumbs=array(
	'Сообщения'=>array('/messages'),
	'Отправленные',
);

$this->menu=array(
	array('label'=>'Полученные', 'url'=>array('inbox')),
        array('label'=>'Отправленные', 'url'=>array('outbox')),
);

?>
<h1>Отправленные сообщения</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'header' => 'Кому',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data["first_name"]." ".$data["last_name"]),array("/user/user/view","id"=>$data["id_rcpt"]))',
		),
		array(
			'header' => 'Сообщение',
			'type'=>'raw',
			'value' => 'CHtml::encode($data["text"])',
                                        
                    ),
            
            
            
                    array(            // display a column with "view", "update" and "delete" buttons
            'class'=>'CButtonColumn','template'=>'{delete}','header'=>'Удалить','deleteButtonUrl'=>'Yii::app()->createUrl("messages/delete&id=".$data["id"]."&where=outbox")'
        ),
            
                    
),
    'emptyText'=>'Нет отправленных сообщений',
    'summaryText'=>'Количество сообщений: {count}'
    )); ?>
