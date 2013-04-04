<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of webuser
 *
 * @author ex
 */
    class WebUser extends CWebUser {
    
    public function getCntMsg()
    {
            
        $db=Yii::app()->db;
	$sql="SELECT count(id) FROM tbl_messages WHERE id_rcpt=:id and status_rcpt=0";
	$cnt=$db->createCommand($sql)->bindValue(':id',$this->id)->queryScalar();
        return $cnt;
                        
    }
   
    public function getLat()
    {
        return $this->getState('__lat');
    }   

    public function getLon() 
    {
        return $this->getState('__lon');
    }   

    public function setLat($value)
    {
        $this->setState('__lat',$value);
    }
    
 
    public function setLon($value)
    {
        $this->setState('__lon',$value);
    }
      

    
    

 /*
    public function la()
    {
        $time=time();
        Yii::app()->session->lastactivity_update($time);
        $this->_la=$time;     
    }
    */
    /*
    public function gc()
    {
        Yii::app()->session->clean_not_active_users();
    }
    
*/

protected function changeIdentity($id,$name,$states)
{
    Yii::app()->getSession()->regenerateID(true);
    $this->setId($id);
    $this->setName($name);
    //$this->setLat();
    //$this->setLon($lon);
    
    $this->loadIdentityStates($states);
    
    
}

///
//

  /*      public function init()
        {
                if (!isset($_COOKIE['PHPSESSID'])) 
                {
                        CApplicationComponent::init();
                } 
                else {
                       parent::init();
                }
        }
        
        public function login($identity,$duration=0, $ll)
        {
                Yii::app()->getSession()->open();
                //parent::login($identity,$duration=0);
                $id=$identity->getId();
                
                //--coords
                $tmp=explode(';', $ll);
                $lat=$tmp[0];
                $lon=$tmp[1];
                //--/
                
                $states=$identity->getPersistentStates();
		if($this->beforeLogin($id,$states,false))
		{
			$this->changeIdentity($id,$identity->getName(),$states, $lat,$lon);

			if($duration>0)
			{
				if($this->allowAutoLogin)
					$this->saveToCookie($duration);
				else
					throw new CException(Yii::t('yii','{class}.allowAutoLogin must be set true in order to use cookie-based authentication.',
						array('{class}'=>get_class($this))));
			}

			$this->afterLogin(false);
		}
		return !$this->getIsGuest();
        }
        
        public function logout($destroySession=true)
        {               
                Yii::app()->request->getCookies()->remove('PHPSESSID');
                parent::logout($destroySession);
        }
        
        public function getIsGuest()
        {
                if (!isset($_COOKIE['PHPSESSID']))
                {
                        return true;
                }
                return parent::getIsGuest();
        }

*/
}
    
     

?>
