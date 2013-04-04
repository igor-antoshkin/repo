<?php
$this->breadcrumbs=array(
	'Радиус',
);

$this->menu=array(
	array('label'=>'Все', 'url'=>array('create')),
	array('label'=>'Мужчины', 'url'=>array('admin')),
        array('label'=>'Женщины', 'url'=>array('admin')),
        array('label'=>'12-18', 'url'=>array('admin')),
        array('label'=>'18-26', 'url'=>array('admin')),
        array('label'=>'26-46', 'url'=>array('admin')),
        array('label'=>'>46', 'url'=>array('admin')),
);
?>

<h1>Ваш радиус</h1>
<h4>Здесь отображаются люди, которые максимально приближены к Вам в данный момент времени.</h4>

<?php 
echo CHtml::script('

$(function() {   

var url_send;
var url_meet;

var txt;

$(document).on("click", ".send", function(){
url_send=$(this).siblings(".ajax_url_send").val();
txt=$(this).siblings(".msg");
$.post(url_send, { txt : txt.val() } ,function(data) {
if (data==1) { txt.val("Sended."); };
});
});

$(document).on("click", ".meet", function(){
url_meet=$(this).siblings(".ajax_url_meet").val();
txt=$(this).siblings(".msg");
$.post(url_meet ,function(data) {
if (data==1) { txt.val("Запрос на встречу отослан."); };
});
});


});

');
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
