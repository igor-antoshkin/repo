<?php

class MeetingsController extends Controller
{

    public $layout='//layouts/column2';
    public $defaultAction='news';
    
    
    	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
    
    public function accessRules()
	{
		return array(
			array('allow',  
				'actions'=>array('news','wait','reply','create','grafovalidator'),
				'users'=>array('@'),
			),
			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    public function actionWait()
	{
	$sql='select tm.id, tp.user_id, tp.first_name, tp.last_name, tp.ava from '.Meetings::model()->tableName().' tm join '.Profile::model()->tableName().' tp on (CASE WHEN tm.id_init='.Yii::app()->user->id.' THEN (tp.user_id=tm.id_reflex) WHEN tm.id_reflex='.Yii::app()->user->id.' THEN (tp.user_id=tm.id_init) END) where (tm.id_init='.Yii::app()->user->id.' or tm.id_reflex='.Yii::app()->user->id.') and (tm.status=1) order by tm.time_create desc';
        $sql_count='select count(id) from '.Meetings::model()->tableName().' where (id_reflex='.Yii::app()->user->id.' or id_init='.Yii::app()->user->id.') and status=1';
        $count=Yii::app()->db->createCommand($sql_count)->queryScalar();

        $dataProvider=new CSqlDataProvider($sql, array(
            'totalItemCount'=>$count,
            'pagination'=>array(
                'pageSize'=>20,
            ), 
        ));
        
           
        $this->render('wait', array('dataProvider'=>$dataProvider));	
        
	}

	public function actionReply($id,$a)
	{
		if (isset($id) and isset($a))
                {  
                   if ($a>0)  { if (Meetings::model()->replyOk($id, $a))  echo "1"; }
                   if ($a==0) { if (Meetings::model()->replyBad($id, $a)) echo "1"; }
                }
	}

        public function actionCreate($id)
	{
		if ( Meetings::model()->createMeet($id) ) echo "1";
        }

        
	public function actionNews()
	{
	$sql='select tm.id, tm.id_init, tp.ava, tp.first_name, tp.last_name from '.Meetings::model()->tableName().' tm join '.Profile::model()->tableName().' tp on tm.id_init=tp.user_id where id_reflex='.Yii::app()->user->id.' and status=0 order by tm.time_create desc';
        $sql_count='select count(id) from '.Meetings::model()->tableName().' where id_reflex='.Yii::app()->user->id.' and status=0';
        $count=Yii::app()->db->createCommand($sql_count)->queryScalar();
        
        $dataProvider=new CSqlDataProvider($sql, array(
            'totalItemCount'=>$count,
            'pagination'=>array(
                'pageSize'=>20,
            ), 
        ));
        
                
        $this->render('news', array('dataProvider'=>$dataProvider));
	}
        
        public function actionGrafovalidator($id, $i, $sel=0)
        {
           
            if ($sel) { return Meetings::model()->insGv($id, $i); }
            
            if ( $code=Meetings::model()->CodeById($id, $i) )
            {    
            
            // prepare canvas.
            $im = imagecreatefromgif('./canvas.gif');
            $rnd=$code;
            // mixing...
            for ($i=0;$i<16;$i+=2)
            {
            $q=hexdec(substr(md5($rnd),$i,2));
            imagecopy($im, $im, $q%100, 34, 0, 0, 30, 30);
            imagecopy($im, $im, 14,$q%100, 30, 0, 30, 30);
            imagecopy($im, $im, $q%100, 12, 60, 0, 30, 30);
            imagecopy($im, $im, 50, $q%100, 1, 31, 30, 30);
            imagecopy($im, $im, $q%100, 92, 31, 31, 30, 30);
            imagecopy($im, $im, 5, $q%100, 61, 31, 30, 30);
            imagecopy($im, $im, $q%100, 5, 0, 61, 30, 30);
            imagecopy($im, $im, 29, $q%100, 31, 61, 30, 30);
            imagecopy($im, $im, $q%100, 25, 61, 61, 30, 30);
            }
            // --append gaussian_blue and emboss
            imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR, IMG_FILTER_EMBOSS);
            // -- printing and free memory
            header('Content-Type: image/gif');
            imagegif($im);
            imagedestroy($im);
            }
        
        }	
}