<?php
$this->breadcrumbs=array(
	'Сообщения'=>array('/messages'),
	'Полученные',
);



echo CHtml::script('
    
$(function() {   

var msg;
var id;
var url_read;
var url_send;
var status_rcpt;
var temp_txt;

$(document).on("click", "a[name=reply]", function(){


msg=$(this).siblings("#id_msg").val();
id=$(this).siblings("#id_sender").val();
url_read=$(this).siblings("#ajax_url_read").val();
status_rcpt=$(this).siblings("#status_rcpt").val();
url_send=$(this).siblings("#ajax_url_send").val();

if (status_rcpt==0)
{
$.post(url_read);
temp_txt=$(this).text();
$(this).find("b").remove();
$(this).text(temp_txt);
$(this).siblings("#status_rcpt").val("1");
}

$("#reply").remove();
$(this).closest("tr").after("<tr><td>Ваш ответ</td><td><textarea id=txt_msg></textarea></td><td><input id=send type=submit value=Отправить></td></tr>").next().attr("id","reply");

});

$(document).on("click", "#send", function(){
$.post(url_send, { txt : $("#txt_msg").val() } ,function(data) {

if (data==1) { $("#reply").remove(); };

});
});

}); 

');

$this->menu=array(
	array('label'=>'Полученные', 'url'=>array('inbox')),
        array('label'=>'Отправленные', 'url'=>array('outbox')),
);

?>
<h1>Полученные сообщения</h1>

<?php
/* TODO: возможно в графе "от Кого" 
стоит писать только имя и фамилию, а при наведении уже выводить фотку.
*/ ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'header' => 'От кого',
			'type'=>'raw',
			'value'=> 'CHtml::link(CHtml::encode($data["first_name"])." ".CHtml::encode($data["last_name"]),array("/user/user/view","id"=>$data["id_sender"]))',
		),
		array(
			'header' => 'Сообщение',
			'type'=>'raw',
			'value' => 'CHtml::link($data["status_rcpt"]?CHtml::encode($data["text"]):CHtml::decode("<b>".$data["text"]."</b>"), CHtml::normalizeUrl("#"), array("name"=>"reply")).CHtml::hiddenField("id_msg",$data["id"]).CHtml::hiddenField("id_sender",$data["id_sender"]).CHtml::hiddenField("ajax_url_read",CHtml::normalizeUrl(array("/messages/read","id"=>$data["id"]))).CHtml::hiddenField("status_rcpt",$data["status_rcpt"]).CHtml::hiddenField("ajax_url_send",CHtml::normalizeUrl(array("/messages/send","id"=>$data["id_sender"])))',
                    ),
            
            
            
                    array(            // display a column with "delete" button
            'class'=>'CButtonColumn','template'=>'{delete}','header'=>'Удалить','deleteButtonUrl'=>'Yii::app()->createUrl("messages/delete&id=".$data["id"]."&where=inbox")'
        ), 
            
                    
),
    'emptyText'=>'Нет полученных сообщений',
    'summaryText'=>'Количество сообщений: {count}'
    )); ?>
