<?php

/**
 * This is the model class for table "{{messages}}".
 *
 * The followings are the available columns in table '{{messages}}':
 * @property string $id
 * @property string $id_sender
 * @property string $id_rcpt
 * @property string $text
 * @property integer $status_sender
 * @property integer $status_rcpt
 * @property string $time_create
 */
class Messages extends CActiveRecord
{

        const STATUS_SENDER_SEND=0;
        const STATUS_SENDER_DELETE=1;
        
        const STATUS_RCPT_NEW=0;
        const STATUS_RCPT_READ=1;
        const STATUS_RCPT_DELETE=2;
    
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Messages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{messages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_sender, id_rcpt, text', 'required'),
			array('status_sender, status_rcpt', 'numerical', 'integerOnly'=>true),
			array('id_sender, id_rcpt', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_sender, id_rcpt, text, status_sender, status_rcpt, time_create', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
         return array();
                
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_sender' => 'Отправитель',
			'id_rcpt' => 'Получатель',
			'text' => 'Text',
			'status_sender' => 'Status Sender',
			'status_rcpt' => 'Status Rcpt',
			'time_create' => 'Time Create',
		);
	}

        public function markRead($id)
        {
           
        if ( $q=$this->model()->find('id=:id and id_rcpt=:id_rcpt', array(':id'=>$id,':id_rcpt'=>Yii::app()->user->id)) )
        { $q->status_rcpt=self::STATUS_RCPT_READ; $q->save(); }
            
        }
        
        public function markDeleteInbox($id)
        {
        
            if ( $q=$this->model()->find('id=:id and id_rcpt=:id_rcpt', array(':id'=>$id,':id_rcpt'=>Yii::app()->user->id)) )
            { $q->status_rcpt=self::STATUS_RCPT_DELETE; $q->save(); }
           
        }
        
        public function markDeleteOutbox($id)
        {
            
            if ( $q=$this->model()->find('id=:id and id_sender=:id_sender', array(':id'=>$id,':id_sender'=>Yii::app()->user->id)) )
             { $q->status_sender=self::STATUS_SENDER_DELETE; $q->save(); }
            
        }
        
        public function sendMessage($txt, $id)
        {
        $q=new Messages;
        $q->id_sender=Yii::app()->user->id;
        $q->id_rcpt=$id;
        $q->text=$txt;
        $q->save();
        
        return $q->hasErrors()?false:true;        
        }
        
        
        public function countNewMessages()
        {
        $q=self::model()->count('id_rcpt=:id and status_rcpt='.self::STATUS_RCPT_NEW, array(':id'=>Yii::app()->user->id));
        return $q;
        }
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('id_sender',$this->id_sender,true);
		$criteria->compare('id_rcpt',$this->id_rcpt,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('status_sender',$this->status_sender);
		$criteria->compare('status_rcpt',$this->status_rcpt);
		$criteria->compare('time_create',$this->time_create,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}