<?php
$this->breadcrumbs=array(
	'Onlines'=>array('index'),
	$model->id_user=>array('view','id'=>$model->id_user),
	'Update',
);

$this->menu=array(
	array('label'=>'List Online', 'url'=>array('index')),
	array('label'=>'Create Online', 'url'=>array('create')),
	array('label'=>'View Online', 'url'=>array('view', 'id'=>$model->id_user)),
	array('label'=>'Manage Online', 'url'=>array('admin')),
);
?>

<h1>Update Online <?php echo $model->id_user; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>