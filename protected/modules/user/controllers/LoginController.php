<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
								$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate() ) {
				
                                   // -- if user already online then logout
                                   if ( !Online::model()->saveOnline($model->ll,Yii::app()->user->id) )     
                                   {
                                   Yii::app()->user->logout();
                                   $this->redirect(Yii::app()->user->returnUrl);
                                   }
/*                                      
                                    $online=new Online;
                                    $ll=explode(';', $model->ll);
                                    $ll_point=new CDbExpression('POINT(:lat, :lon)', array(':lat' => $ll[0], ':lon' => $ll[1]));
                                    $online->id_user=Yii::app()->user->id;
                                    $online->ll=$ll_point;
                                    $online->lat=$ll[0];
                                    $online->lon=$ll[1];
                                    $online->la=time();
                                    $online->save();
  */                                          
                                    /*
                                $ll=explode(';', $model->ll);
                                $r=rand(1, 1000000);
                        
                                Yii::app()->user->lat=$ll[0];
                               Yii::app()->user->lon=$ll[1];
                                */
                               // Yii::app()->session->writell($ll[0],$ll[1],Yii::app()->User->id);   
//                             //                               
                              //  Yii::app()->user->gc();

                                    
                                    $this->lastViset();
					if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit_at = date('Y-m-d H:i:s');
		$lastVisit->save();
	}


}