<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array('Login',);
?>

<?php
echo CHtml::scriptFile('http://code.jquery.com/jquery-latest.min.js');
echo CHtml::scriptFile('ikway_scripts.js');
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php echo CHtml::form('', 'post', array('id'=>'login-form')); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
        
        <div class="row">
		<?php 
                echo CHtml::label('Vvedite adres', 'addr');
                echo CHtml::activeTextField($model, 'addr',array('id'=>'addr','value'=>'ленина 17 днепропетровск'));
                echo CHtml::error($model, 'addr');
          
                ?>
        </div>
        
                <div class="row">
		<?php 
                echo CHtml::label('Username', 'username');
                echo CHtml::activeTextField($model, 'username',array('id'=>'username'));
                echo CHtml::error($model, 'username');
          
                ?>
                    
                <div class="row">
		<?php 
                echo CHtml::label('Password', 'password');
                echo CHtml::activeTextField($model, 'password',array('id'=>'password'));
                echo CHtml::error($model, 'password');
          
                ?>
                    

        
        <div id="results"></div> 
        


<?php echo CHtml::endForm(); ?>
</div><!-- form -->
