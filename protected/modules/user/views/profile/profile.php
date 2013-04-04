<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);
$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);




echo CHtml::scriptFile('http://code.jquery.com/jquery-latest.min.js');

echo CHtml::script('

$(function() {

var status_banner_text;
var status_edit;
var textarea;
var ajax_status="'.CHtml::normalizeUrl(array('/user/profile/updatestatus')).'";
var ajax_mood="'.CHtml::normalizeUrl(array('/user/profile/updatemood')).'";

$(document).on("click", "#status_banner", function(){
status_banner_text=$(this).html();
textarea="<textarea cols=55 id=status_edit>"+status_banner_text+"</textarea>";
$(this).html("");
$(this).closest("td").append(textarea);
$("#status_edit").focus();
});

$(document).on("blur", "#status_edit", function(){
status_edit=$(this).val();
$.post(ajax_status, { txt : status_edit }, function(data) {
if (data==1) { 
$("#status_edit").prev().text(status_edit);
$("#status_edit").remove();
}
}); 
});

$(document).on("change", "input[name=mood]", function(){
$.post(ajax_mood, { mode : $(this).attr("value") }, function(data) {
if (data!=1) { $("input[name=mood]").removeAttr("checked"); }
});
});

});

');


?><h1><?php echo UserModule::t('Your profile'); ?></h1>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
	<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<table class="dataGrid">
	<tr>
		<th class="label"><?php echo CHtml::encode($model->profile->first_name.' '.$model->profile->last_name); /* CHtml::encode($model->getAttributeLabel('username')); */ ?></th>
	    <td><?php /* echo CHtml::encode($model->username); */ ?></td>
	</tr>
	
        <tr>
            <th class="label"><?php echo CHtml::image(Yii::app()->getBaseUrl(true).'/'.$model->profile->ava, 'Photo');  ?></th>
            <td><?php echo CHtml::tag('span', array('style'=>'cursor:pointer','id'=>'status_banner'), CHtml::encode($model->profile->status_text), 'true'); ?></td>
        </tr>
        
        <tr>
            <th class="label">Моё настроение</th>
            <td><?php echo CHtml::radioButtonList('mood', $model->profile->mood, array('0'=>'Творческое','1'=>'Веселое','2'=>'Пивное','3'=>'Счастливое')); ?></td>
        </tr>
        
            <?php 
	/*	$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
		if ($profileFields) {
			foreach($profileFields as $field) {
				//echo "<pre>"; print_r($profile); die();
	*/		?>
	<tr>
		<th class="label"><?php /* echo (($field->widgetView($profile))?$field->widgetView($profile):CHtml::encode((($field->range)?Profile::range($field->range,$profile->getAttribute($field->varname)):$profile->getAttribute($field->varname)))); */ /* CHtml::encode(UserModule::t($field->title)); */ ?></th>
    	<td><?php /* echo (($field->widgetView($profile))?$field->widgetView($profile):CHtml::encode((($field->range)?Profile::range($field->range,$profile->getAttribute($field->varname)):$profile->getAttribute($field->varname)))); */ ?></td>
	</tr>
			<?php
		/*	}//$profile->getAttribute($field->varname)
		} */
	?>
	<tr>
		<th class="label"></th><td><?php /* echo CHtml::encode($model->getAttributeLabel('email')); ?></th>
    	<td><?php echo CHtml::encode($model->email); ?></td>
	</tr>
	<tr>
		<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('create_at')); ?></th>
    	<td><?php echo $model->create_at; ?></td>
	</tr>
	<tr>
		<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('lastvisit_at')); ?></th>
    	<td><?php echo $model->lastvisit_at; ?></td>
	</tr>
	<tr>
		<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('status')); ?></th>
    	<td><?php echo CHtml::encode(User::itemAlias("UserStatus",$model->status)); */ ?></td>
	</tr>
</table>
