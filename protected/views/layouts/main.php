<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
            
            <div id="logo"><?php /*echo CHtml::encode(Yii::app()->name);*/ echo "<font color=#c9e0ed face=Tahoma><b>ik</b></font>"."<font face=Tahoma color=#c9e0ff><u><b>w</b></u></font>"."<font color=#c9e0ed face=Tahoma><b>ay</b></font>"; ?> 
                <?php
                if (!Yii::app()->user->isGuest) {
                echo '<div class="span-2 small last" style="float:right"><span class="small">'.CHtml::link(Yii::app()->getModule('user')->t("Logout"), Yii::app()->getModule('user')->logoutUrl).'</span></div> 
                <div class="span-9 small " style="float:right"><span class="small">Ваш рейтинг: '.Yii::app()->user->Rating.'</span></div> ';
                }
                    ?>
            </div>
                     
        </div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>Yii::app()->getModule('user')->t("Profile"), 'url'=>Yii::app()->getModule('user')->profileUrl,  'visible'=>!Yii::app()->user->isGuest, 'active' => ($this->id === 'profile')),
                                array('label'=>'Мой радиус', 'url'=>array('/online'), 'visible'=>!Yii::app()->user->isGuest, 'active' => ($this->id === 'online')),
                                array('label'=>'Встречи'.((Yii::app()->user->CntMeets>0)?' ['.Yii::app()->user->cntMeets.']':''), 'url'=>array('/meetings'), 'visible'=>!Yii::app()->user->isGuest, 'active' => ($this->id === 'meetings')),
				array('label'=>'Сообщения'.((Yii::app()->user->CntMsg>0)?' ['.Yii::app()->user->cntMsg.']':''), 'url'=>array('/messages'), 'visible'=>!Yii::app()->user->isGuest, 'active' => ($this->id === 'messages')),
                                array('label'=>Yii::app()->getModule('user')->t("Login"), 'url'=>Yii::app()->getModule('user')->loginUrl,  'visible'=>Yii::app()->user->isGuest, 'active' => ($this->id === 'login')),
                                array('label'=>Yii::app()->getModule('user')->t("Register"), 'url'=>Yii::app()->getModule('user')->registrationUrl, 'visible'=>Yii::app()->user->isGuest, 'active' => ($this->id === 'registration')),
                                array('label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->user->name.')', 'url'=>Yii::app()->getModule('user')->logoutUrl,  'visible'=>!Yii::app()->user->isGuest)
                            
                            ),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by ik<u>w</u>ay.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
