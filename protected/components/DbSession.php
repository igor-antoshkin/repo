<?php

class DbSession extends CDbHttpSession{

    /*
protected function createSessionTable($db,$tableName)
{
$sql="
CREATE TABLE $tableName
(
	id CHAR(32) PRIMARY KEY,
	expire INTEGER,
	data VARCHAR(2000),
        lat DECIMAL(11,6),
        lon DECIMAL(11,6),
        id_user INTEGER,
        ll Point NOT NULL,
        Spatial Index ll_key (ll)
    ) ENGINE=MyISAM;
        ";
		$db->createCommand($sql)->execute();
                
}

	public function writeSession($id,$data)
	{
		// exception must be caught in session write handler
		// http://us.php.net/manual/en/function.session-set-save-handler.php
		try
		{
			$expire=time()+$this->getTimeout();
			$db=$this->getDbConnection();
			$sql="SELECT id FROM {$this->sessionTableName} WHERE id=:id";
			if($db->createCommand($sql)->bindValue(':id',$id)->queryScalar()===false)
                        {
                        //$ll=new CDbExpression('POINT(0.000000, 0.000000)');
                            $sql="INSERT INTO {$this->sessionTableName} (id, data, expire) VALUES (:id, :data, $expire)";
                                                   
                        }
				
			else
				$sql="UPDATE {$this->sessionTableName} SET expire=$expire, data=:data WHERE id=:id";
			$db->createCommand($sql)->bindValue(':id',$id)->bindValue(':data',$data)->execute();
		}
		catch(Exception $e)
		{
			if(YII_DEBUG)
				echo $e->getMessage();
			// it is too late to log an error message here
			return false;
                   ///Yii::app()->request->getCookies()->remove('PHPSESSID');
		}
		return true;
	}

 public function regenerateID($deleteOldSession=false, $lat, $lon, $id)
	{
		$oldID=session_id();

		// if no session is started, there is nothing to regenerate
		if(empty($oldID))
			return;

		//parent::regenerateID(true);
		$newID=session_id();
		$db=$this->getDbConnection();

		$sql="SELECT * FROM {$this->sessionTableName} WHERE id=:id";
		$row=$db->createCommand($sql)->bindValue(':id',$oldID)->queryRow();
		if($row!==false)
		{
			if($deleteOldSession)
			{
				$sql="UPDATE {$this->sessionTableName} SET id=:newID WHERE id=:oldID";
				$db->createCommand($sql)->bindValue(':newID',$newID)->bindValue(':oldID',$oldID)->execute();
			}
			else
			{
				$row['id']=$newID;
				$db->createCommand()->insert($this->sessionTableName, $row);
			}
		}
		else
		{
		
                     $ll=new CDbExpression('POINT(:lat, :lon)', array(':lat' => $lat, ':lon' => $lon));

                        // shouldn't reach here normally
			$db->createCommand()->insert($this->sessionTableName, array(
				'id'=>$newID,
				'expire'=>time()+$this->getTimeout(),
                                'll'=>$ll,
                                'lat'=>$lat,
                                'lon'=>$lon,
                                'id_user'=>$id                                                    
			));
		}
	}

        
/*
public function lastactivity_update($time)
{
		try
		{
			$id=$this->sessionID;
                        $db=$this->getDbConnection();
			$sql="SELECT id FROM {$this->sessionTableName} WHERE id=:id";
			if($db->createCommand($sql)->bindValue(':id',$id)->queryScalar()!==false)
                        {
                        $sql="UPDATE {$this->sessionTableName} SET la=$time WHERE id=:id";
			$db->createCommand($sql)->bindValue(':id',$id)->execute();
                        }
				
		}
		catch(Exception $e)
		{
			if(YII_DEBUG)
				echo $e->getMessage();
			// it is too late to log an error message here
			return false;
		}
    
return true;  
}


//
public function clean_not_active_users()
        {
    try
		{
			 
                        $time=time()+$this->getTimeout()-480;
                        $db=$this->getDbConnection();
                        $sql="DELETE FROM {$this->sessionTableName} WHERE expire<:time or data=''";
			$db->createCommand($sql)->bindValue(':time',$time)->execute();
				
		}
		catch(Exception $e)
		{
			if(YII_DEBUG)
				echo $e->getMessage();
			// it is too late to log an error message here
			return false;
		}
    
        }
*/

    
}

?>
