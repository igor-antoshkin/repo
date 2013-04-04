<?php

/**
 * This is the model class for table "{{online}}".
 *
 * The followings are the available columns in table '{{online}}':
 * @property integer $la
 * @property double $lat
 * @property double $lon
 * @property integer $id_user
 * @property string $ll
 */
class Online extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Online the static model class
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
		return '{{online}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('la, lat, lon, id_user, ll', 'required'),
			array('la, id_user', 'numerical', 'integerOnly'=>true),
			array('lat, lon', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('la, lat, lon, id_user, ll', 'safe', 'on'=>'search'),
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
			'la' => 'La',
			'lat' => 'Lat',
			'lon' => 'Lon',
			'id_user' => 'Id User',
			'll' => 'Ll',
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

		$criteria->compare('la',$this->la);
		$criteria->compare('lat',$this->lat);
		$criteria->compare('lon',$this->lon);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('ll',$this->ll,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /*  */
        
        public function saveOnline($lat_lot, $id)
        {

        // garbage collector
        $this->model()->deleteAll('la<:time', array(':time'=>time()-480));
       
        // check if user already online 
        if ( $this->model()->find('id_user=:id', array(':id'=>$id)) !== null )
        { return false; }
        
        
        
        $online=new $this;
        $ll=explode(';', $lat_lot);
        $ll_point=new CDbExpression('POINT(:lat, :lon)', array(':lat' => $ll[0], ':lon' => $ll[1]));
        $online->id_user=$id;
        $online->ll=$ll_point;
        $online->lat=$ll[0];
        $online->lon=$ll[1];
        $online->la=time();
        $online->save();
        
        Yii::app()->user->lat=$ll[0];
        Yii::app()->user->lon=$ll[1];
        
        return true;
                                    
        }
        
        public function deleteOnline($id)
        {
        $this->model()->deleteall('id_user=:id', array(':id'=>$id));
        }
        
        public function updOnline($id)
        {
        
        if ($this->model()->find('id_user=:id', array(':id'=>$id)) === null)
        { 
        $lat=Yii::app()->user->lat;
        $lon=Yii::app()->user->lon;
        $ll_point=new CDbExpression('POINT(:lat, :lon)', array(':lat' => $lat, ':lon' => $lon));
        $online=new $this;
        
        $online->la=time();
        $online->id_user=$id;
        $online->ll=$ll_point;
        $online->lat=$lat;
        $online->lon=$lon;
        $online->save();     
        return true; 
          
        }
        
        
             $q=$this->model()->find('id_user=:id', array(':id'=>$id));
             $q->la=time();
             $q->save(); 
             
            
        
   
        }
        
}