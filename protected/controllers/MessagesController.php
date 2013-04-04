<?php

class MessagesController extends Controller
{
    
    public $layout='//layouts/column2';
    public $defaultAction='inbox';
    
	public function actionInbox()
	{
            
        $sql='select * from '.Messages::model()->tableName().' tm join '.Profile::model()->tableName().' tp on tm.id_sender=tp.user_id where tm.id_rcpt='.Yii::app()->user->id.' and (tm.status_rcpt=0 or tm.status_rcpt=1) order by tm.time_create DESC';
        $sql_count='select count(*) from '.Messages::model()->tableName().' where id_rcpt='.Yii::app()->user->id.' and status_rcpt<>2';
        $count=Yii::app()->db->createCommand($sql_count)->queryScalar();

        $dataProvider=new CSqlDataProvider($sql, array(
            'totalItemCount'=>$count,
            'pagination'=>array(
                'pageSize'=>20,
            ), 
        ));            
           
        $this->render('inbox', array('dataProvider'=>$dataProvider));
	}
        
        public function actionOutbox()
	{
            	
        $sql='select * from '.Messages::model()->tableName().' tm join '.Profile::model()->tableName().' tp on tm.id_rcpt=tp.user_id where tm.id_sender='.Yii::app()->user->id.' and tm.status_sender=0 order by tm.time_create DESC';
        $sql_count='select count(*) from '.Messages::model()->tableName().' where id_sender='.Yii::app()->user->id.' and status_sender<>1';
        $count=Yii::app()->db->createCommand($sql_count)->queryScalar();

        $dataProvider=new CSqlDataProvider($sql, array(
            'totalItemCount'=>$count,
            'pagination'=>array(
                'pageSize'=>20,
            ), 
        ));
             
        $this->render('outbox', array('dataProvider'=>$dataProvider));
         
        }

        public function actionRead($id)
	{
		if (isset($id))
                { Messages::model()->markRead($id); }
                $this->redirect(array('inbox'));
	}
        
        public function actionDelete($id,$where)
	{
		if (isset($id) and isset($where))
                { 
                  if ($where=='inbox')  Messages::model()->markDeleteInbox($id); 
                  if ($where=='outbox') Messages::model()->markDeleteOutbox($id);
                }
	}
        
        public function actionSend($id)
	{
		
                if (isset($_POST['txt']) and isset($id)) 
                { 
                    $txt=$_POST['txt'];    
                   if ( Messages::model()->sendMessage($txt, $id) ) echo "1";
                }
                
	}
        
	

        public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('inbox','read','delete','send', 'outbox'),
				'users'=>array('@'),
			),
			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
        public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	

}