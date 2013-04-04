<?php
$this->breadcrumbs=array(
	'Onlines'=>array('index'),
	$model->id_user,
);

$this->menu=array(
	array('label'=>'List Online', 'url'=>array('index')),
	array('label'=>'Create Online', 'url'=>array('create')),
	array('label'=>'Update Online', 'url'=>array('update', 'id'=>$model->id_user)),
	array('label'=>'Delete Online', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_user),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Online', 'url'=>array('admin')),
);
?>

<h1>View Online #<?php echo $model->id_user; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'la',
		'lat',
		'lon',
		'id_user',
		'll',
	),
)); ?>
