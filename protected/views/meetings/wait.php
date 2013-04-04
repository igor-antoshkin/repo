<?php
$this->breadcrumbs=array(
	'Встречи'=>array('/meetings'),
	'Ожидающие',
);

$this->menu=array(
	array('label'=>'Новые', 'url'=>array('news')),
	array('label'=>'Ожидающие подтверждения', 'url'=>array('wait')),
);

echo CHtml::script('

$(function() {

var url;
var td;

$(document).on("click", ".gv", function(){
if(!confirm("Вы уверены?")) return false;

url=$(this).attr("src")+"&sel=1";
td=$(this).closest("td");

$.post(url, function(data) {
$(this).remove();
if (data==0) {td.html("Внезапная ошибка настигла нас.");} 
if (data==1) {td.html("Ваш выбор учтен. Ожидайте выбор Вашего партнера.");} 
if (data==2) {td.html("К сожалению Ваш партнер сделал неверный выбор. Встреча аннулирована.");} 
if (data==3) {td.html("Поздравляем! Встреча засчитана.");} 
if (data==4) {td.html("Вы сделали неверный выбор. Встреча аннулирована.");} 
if (data==5) {td.html("Вы с вашим партнером сделали неверный выбор. Встреча аннулирована.");} 
});

});

});

');

?>
<h1>Ожидающие встречи</h1>
<h4>После того, как Вы встретились с человеком, необходимо засвидетельствовать Вашу встречу. Для этого сравните Ваши графовалидаторы, найдите общий - и укажите его здесь. Если вы совместно(<b>!</b>) делаете правильный выбор, встреча засчитывается и вы вместе получаете вознаграждание. Будьте предельно внимательны!</h4>
<h5>Помните! Встречу с конкретным человеком, можно организовать только 1 раз в день.</h5>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'header' => 'С кем',
			'type'=>'raw',
			//'value' => '($data->id_init==Yii::app()->user->id) ? CHtml::link(CHtml::encode($data->id_reflex),array("/site","id"=>$data->id_reflex)) : CHtml::link(CHtml::encode($data->id_init),array("/site","id"=>$data->id_init)) ',
                        'value'=>'CHtml::link(CHtml::encode($data["first_name"])." ".CHtml::encode($data["last_name"]),array("/user/user/view","id"=>$data["user_id"]))'
		),
		array(
			'header' => 'Графовалидатор встречи',
			'type'=>'raw',
			'value' => 'CHtml::image(CHtml::normalizeUrl(array("/meetings/grafovalidator", "id"=>$data["id"], "i"=>0)),"",array("class"=>"gv","style"=>"cursor:pointer"))."   ".CHtml::image(CHtml::normalizeUrl(array("/meetings/grafovalidator", "id"=>$data["id"], "i"=>1)),"",array("class"=>"gv","style"=>"cursor:pointer"))."   ".CHtml::image(CHtml::normalizeUrl(array("/meetings/grafovalidator", "id"=>$data["id"], "i"=>2)),"",array("class"=>"gv","style"=>"cursor:pointer"))."   ".CHtml::image(CHtml::normalizeUrl(array("/meetings/grafovalidator", "id"=>$data["id"], "i"=>3)),"",array("class"=>"gv","style"=>"cursor:pointer"))',
                    ),
            
                    
),
    'emptyText'=>'Нет назначенных встреч',
    'summaryText'=>'Количество назначенных встреч: {count}'
    )); 

?>


