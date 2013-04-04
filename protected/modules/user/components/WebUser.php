<?php

class WebUser extends CWebUser
{

    public function getCntMsg()
    {
        return Messages::model()->countNewMessages();
    }
    
    public function getCntMeets()
    {
        return Meetings::model()->countNewMeetings();
    }
   
    public function getRating()
    {
        return Profile::model()->getRating();
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

protected function changeIdentity($id,$name,$states)
{
    Yii::app()->getSession()->regenerateID(true);
    $this->setId($id);
    $this->setName($name);
    //$this->setLat();
    //$this->setLon($lon);
    
    $this->loadIdentityStates($states);
    
    
}

    /**
     * @var boolean whether to enable cookie-based login. Defaults to false.
     */
    public $allowAutoLogin=true;
    /**
     * @var string|array the URL for login. If using array, the first element should be
     * the route to the login action, and the rest name-value pairs are GET parameters
     * to construct the login URL (e.g. array('/site/login')). If this property is null,
     * a 403 HTTP exception will be raised instead.
     * @see CController::createUrl
     */
    public $loginUrl=array('/user/login');

    public function getRole()
    {
        return $this->getState('__role');
    }
    
    public function getId()
    {
        return $this->getState('__id') ? $this->getState('__id') : 0;
    }

    protected function afterLogin($fromCookie)
	{
        parent::afterLogin($fromCookie);
        $this->updateSession();
	}

    public function updateSession() {
        $user = Yii::app()->getModule('user')->user($this->id);
        $this->name = $user->username;
        $userAttributes = CMap::mergeArray(array(
                                                'email'=>$user->email,
                                                'username'=>$user->username,
                                                'create_at'=>$user->create_at,
                                                'lastvisit_at'=>$user->lastvisit_at,
                                           ),$user->profile->getAttributes());
        foreach ($userAttributes as $attrName=>$attrValue) {
            $this->setState($attrName,$attrValue);
        }
    }

    public function model($id=0) {
        return Yii::app()->getModule('user')->user($id);
    }

    public function user($id=0) {
        return $this->model($id);
    }

    public function getUserByName($username) {
        return Yii::app()->getModule('user')->getUserByName($username);
    }

    public function getAdmins() {
        return Yii::app()->getModule('user')->getAdmins();
    }

    public function isAdmin() {
        return Yii::app()->getModule('user')->isAdmin();
    }

}