<div class="view">

<?php

echo CHtml::image(Yii::app()->request->baseUrl.'/'.CHtml::encode($data['ava']));

echo "<br>";
echo CHtml::encode($data['status_text']);
echo "<br>";
echo CHtml::encode($data['mood']);

echo "<br>";

echo CHtml::encode($data['first_name']).' '.CHtml::encode($data['last_name']).', '.CHtml::encode($data['age']).' возраст';
echo "<br>";
echo CHtml::encode('Расстояние между вами: ').CHtml::encode($data['dist']).' км';
echo "<br>";
//echo CHtml::encode($data['birthday']);

echo "<br>";
echo CHtml::textArea('' , '', array('class'=>'msg'));
echo "<br>";
echo CHtml::button('Отправить сообщение', array('class'=>'send'));

echo "<br><br>";
echo CHtml::button('Назначить встречу', array('class'=>'meet'));

echo "<br><br>";

echo CHtml::link('vk_url', 'http://'.CHtml::encode($data['vk_url']));
echo "<br>";
echo CHtml::link('fb_url', 'http://'.CHtml::encode($data['fb_url']));
echo "<br>";
echo CHtml::link('tw_url', 'http://'.CHtml::encode($data['tw_url']));

echo CHtml::hiddenField('', CHtml::normalizeUrl(array("/messages/send","id"=>$data['id_user'])), array('class'=>'ajax_url_send'));
echo CHtml::hiddenField('', CHtml::normalizeUrl(array("/meetings/create","id"=>$data['id_user'])), array('class'=>'ajax_url_meet'));


?>


</div>