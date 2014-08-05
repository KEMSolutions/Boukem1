<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	
	public function validatePassword($user)
	{
		if ($user->password){
			return CPasswordHelper::verifyPassword($this->password,$user->password);
		}
		return true;
	}
	
	/**
	 * If set to true, will prevent the creation of a new account if no password is specified (default behavior). Useful in a strict login form.
	 */
	public $preventNewAccountCreation = false;
	
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		
		
		$username=strtolower($this->username);
		$user=User::model()->find('LOWER(email)=:username',array(":username"=>$username));
		
		
		if ($user===null && $this->password !== null){
			$this->errorCode=self::ERROR_USERNAME_INVALID;
			
			return !$this->errorCode;
		}
		
		if ($user!==null && !Yii::app()->controller->isB2b()){
			// Check for the validity of the password
			if ($this->validatePassword($user)){
				$this->errorCode=self::ERROR_NONE;
			} else {
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			}
		} else {
			
			if ($user === null){
				// Create a user with just a username
				$user = new User;
				$user->email = strtolower($this->username);
				$user->save();
			}
			
			$this->errorCode=self::ERROR_NONE;
			
		}
		
		
		
		$this->setState('user', $user);
		
		return !$this->errorCode;
	}
	
	
	
}