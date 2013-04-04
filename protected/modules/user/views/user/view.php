<?php

$this->layout='//layouts/column1';
$this->menu=array(
    array('label'=>UserModule::t('List User'), 'url'=>array('index')),
);
?>
<hr>
<?php 
/*
// For all users
	$attributes = array(
			'username',
	);
	
	$profileFields=ProfileField::model()->forAll()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			array_push($attributes,array(
					'label' => UserModule::t($field->title),
					'name' => $field->varname,
					'value' => (($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname))),

				));
		}
	}
	array_push($attributes,
		'create_at',
		array(
			'name' => 'lastvisit_at',
			'value' => (($model->lastvisit_at!='0000-00-00 00:00:00')?$model->lastvisit_at:UserModule::t('Not visited')),
		)
	);
			
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));
*/
?>
<table class="dataGrid">
	<tr>
		<th class="label"><?php echo CHtml::encode($model->profile->first_name.' '.$model->profile->last_name); /* CHtml::encode($model->getAttributeLabel('username')); */ ?></th>
	    <td><?php /* echo CHtml::encode($model->username); */ ?></td>
	</tr>
	
        <tr>
            <th class="label"><?php echo CHtml::image(Yii::app()->getBaseUrl(true).'/'.$model->profile->ava, 'Photo');  ?></th>
            <td><?php echo CHtml::tag('span', array(), CHtml::encode($model->profile->status_text), 'true'); ?></td>
        </tr>
        
        <tr>
            <th class="label">Моё настроение</th>
            <td><?php echo $model->profile->mood; ?></td>
        </tr>
        
        <tr>
            <th class="label">VK</th>
            <td><?php echo CHtml::link('vk', $model->profile->vk_url); ?></td>
        </tr>
   
        <tr>
            <th class="label">Facebook</th>
            <td><?php echo CHtml::link('facebook', $model->profile->fb_url); ?></td>
        </tr>
        
        <tr>
            <th class="label">Twitter</th>
            <td><?php echo CHtml::link('twitter', $model->profile->tw_url); ?></td>
        </tr>
        
</table>
