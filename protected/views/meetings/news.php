<?php
$this->breadcrumbs=array(
	'Встречи'=>array('/meetings'),
	'Новые',
);

echo CHtml::script('
    
$(function() {   

var ajax_meet_yes;
var ajax_meet_no;
var tr;

$(document).on("click", ".yes", function(){
$(this).attr("class","yes_send");
tr=$(this).closest("tr");
ajax_meet_yes=$(this).siblings(".ajax_meet_yes").val();
$.post(ajax_meet_yes, function(data) {
if (data==1) { tr.remove(); }
});

});

$(document).on("click", ".no", function(){
$(this).attr("class","no_send");
tr=$(this).closest("tr");
ajax_meet_no=$(this).siblings(".ajax_meet_no").val();
$.post(ajax_meet_no, function(data) {
if (data==1) { tr.remove(); }
});

});

});


');

$this->menu=array(
	array('label'=>'Новые', 'url'=>array('news')),
	array('label'=>'Ожидающие подтверждения', 'url'=>array('wait')),
);

?>

<h1>Новые встречи</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'header' => 'Кто назначил',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data["first_name"]." ".$data["last_name"]),array("/user/user/view","id"=>$data["id_init"]))',
		),
		array(
			'header' => 'Ваше решение',
			'type'=>'raw',
			'value' => '"<center>".CHtml::button("Принять приглашение", array("class"=>"yes")).CHtml::button("Отклонить", array("class"=>"no")).CHtml::hiddenField("",CHtml::normalizeUrl(array("/meetings/reply","id"=>$data["id"], "a"=>1)), array("class"=>"ajax_meet_yes")).CHtml::hiddenField("",CHtml::normalizeUrl(array("/meetings/reply","id"=>$data["id"], "a"=>0)), array("class"=>"ajax_meet_no"))."</center>"',
                    ),
            
                    
),
    'emptyText'=>'Пока вам никто не назначил встречу',
    'summaryText'=>'Количество новых встреч: {count}'
    )); ?>