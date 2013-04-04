<?php

/**
 * This is the model class for table "{{meetings}}".
 *
 * The followings are the available columns in table '{{meetings}}':
 * @property string $id
 * @property string $id_init
 * @property string $id_reflex
 * @property integer $status
 * @property string $code_init
 * @property string $code_reflex
 * @property string $code_common
 * @property integer $select_gv
 * @property string $time_create
 */
class Meetings extends CActiveRecord
{
	const STATUS_NEW=0;
        const STATUS_ORDER_ACCEPT=1;
        const STATUS_ORDER_REJECT=2;
        const STATUS_OK=3;
        const STATUS_NOT_CONFIRMED=4;
        
        //-- min. time between meetings with unique person (in seconds). 
        //-- default=12 hours.
        const TIME_MEET_PERIOD=43200;
        
        //-- count of graphoValidator images. default=4.
        const COUNT_GV=4;
        
	
        
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Meetings the static model class
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
		return '{{meetings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
			array('status, sel_init, sel_reflex', 'numerical', 'integerOnly'=>true),
			array('id_init, id_reflex', 'length', 'max'=>10),
			array('code_init, code_reflex', 'length', 'max'=>45),
			array('code_common', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_init, id_reflex, status, sel_init, sel_reflex, code_init, code_reflex, code_common, time_create', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_init' => 'Id Init',
			'id_reflex' => 'Id Reflex',
			'status' => 'Status',
			'code_init' => 'Code Init',
			'code_reflex' => 'Code Reflex',
			'code_common' => 'Code Common',
                        'sel_init' => 'Sel Init',
                        'sel_reflex' => 'Sel Reflex',
			'time_create' => 'Time Create',
		);
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
		$criteria->compare('id_init',$this->id_init,true);
		$criteria->compare('id_reflex',$this->id_reflex,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('code_init',$this->code_init,true);
		$criteria->compare('code_reflex',$this->code_reflex,true);
		$criteria->compare('code_common',$this->code_common,true);
                $criteria->compare('sel_init',$this->sel_init,true);
                $criteria->compare('sel_reflex',$this->sel_reflex,true);
		$criteria->compare('time_create',$this->time_create,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function countNewMeetings()
        {
        $q=self::model()->count('id_reflex=:id and status='.self::STATUS_NEW,array(':id'=>Yii::app()->user->id));
        return $q;
        }
        
        public function createMeet($id) 
        {
        
        // checking on self-meeting
        if (Yii::app()->user->id==$id) {return false;}
        
        // checking of over-meeting. 1 person->1 meet->1 TIME_MEET_PERIOD(12h).
        $cnt=self::model()->count('((id_init=:id_init and id_reflex=:id_reflex) or (id_init=:id_reflex and id_reflex=:id_init)) and (unix_timestamp(time_create)>unix_timestamp()-'.self::TIME_MEET_PERIOD.') and (status<>'.self::STATUS_ORDER_REJECT.')', array(':id_init'=>Yii::app()->user->id,':id_reflex'=>$id));
        if ($cnt>0) {return false;}    
        
        //-TODO: checking on exist open-meet with user
        
        // - create meet
        $q=new $this;
        $q->id_init=Yii::app()->user->id;
        $q->id_reflex=$id;
        $q->save();
        return $q->hasErrors()?false:true;        
                
        }
        
        public function replyOk($id, $a) 
        {
            
        if ( $q=self::model()->find('id=:id and id_reflex=:id_reflex', array(':id'=>$id,':id_reflex'=>Yii::app()->user->id)) )
                { 
                    
            // -- generation codes for initiator and reflexor
            $code_common=mt_rand(0,9999);
            $code_init_arr=array($code_common,mt_rand(0,9999),mt_rand(0,9999),mt_rand(0,9999));       
            $code_reflex_arr=array($code_common,mt_rand(0,9999),mt_rand(0,9999),mt_rand(0,9999));
            shuffle($code_init_arr); shuffle($code_reflex_arr);
            $code_init=implode('#',$code_init_arr); 
            $code_reflex=implode('#',$code_reflex_arr);
            
            // --
                    // -- recodring in DB.
                    $q->status=self::STATUS_ORDER_ACCEPT;
                    $q->code_init=$code_init;
                    $q->code_reflex=$code_reflex;
                    $q->code_common=$code_common;
                    $q->save(); 
                    return $q->hasErrors()?false:true;
                }
        
        }
        
        public function replyBad($id, $a) 
        {
        
        if ( $q=self::model()->find('id=:id and id_reflex=:id_reflex', array(':id'=>$id,':id_reflex'=>Yii::app()->user->id)) )
                { 
                    $q->status=self::STATUS_ORDER_REJECT; 
                    $q->save(); 
                    return $q->hasErrors()?false:true;
                }    
            
        }
        
        public function CodeById($id, $num)
        {
            if ( $q=self::model()->findByPk($id) )
            { 
                if ($q->id_init   == Yii::app()->user->id) { $code_arr=explode('#',$q->code_init);   return $code_arr[$num%self::COUNT_GV]; }
                if ($q->id_reflex == Yii::app()->user->id) { $code_arr=explode('#',$q->code_reflex); return $code_arr[$num%self::COUNT_GV]; }
            }
            
        }
        
        public function insGv($id, $num)
        {
            if ( $q=self::model()->findByPk($id) )
            { 
                $v=false;
                if ($q->id_init   == Yii::app()->user->id) { $v=true; $sel_my='sel_init';   $sel_not='sel_reflex'; $code_arr=explode('#',$q->code_init);   }
                if ($q->id_reflex == Yii::app()->user->id) { $v=true; $sel_my='sel_reflex'; $sel_not='sel_init';   $code_arr=explode('#',$q->code_reflex); }
                if (!$v) return false;
                
                    //$sel=$q->select_gv;
                    if ($code_arr[$num%self::COUNT_GV]==$q->code_common) { $q->$sel_my=1; }
                    if ($code_arr[$num%self::COUNT_GV]!=$q->code_common) { $q->$sel_my=2; }
                    
                    if ($q->$sel_my==1 and $q->$sel_not==0)  { $ret="1"; }
                    if ($q->$sel_my==2 and $q->$sel_not==0)  { $ret="1"; }
                    if ($q->$sel_my==1 and $q->$sel_not==1)  { $ret="3"; $q->status=self::STATUS_OK; Profile::model()->addRating($q->id_init,$q->id_reflex); }
                    if ($q->$sel_my==2 and $q->$sel_not==1)  { $ret="4"; $q->status=self::STATUS_NOT_CONFIRMED; }
                    if ($q->$sel_my==1 and $q->$sel_not==2)  { $ret="2"; $q->status=self::STATUS_NOT_CONFIRMED; }
                    if ($q->$sel_my==2 and $q->$sel_not==2)  { $ret="5"; $q->status=self::STATUS_NOT_CONFIRMED; }
                    
                    $q->save();
                                        
                    echo ($q->hasErrors())?0:$ret; 
                    
            }
            
        }

        
}