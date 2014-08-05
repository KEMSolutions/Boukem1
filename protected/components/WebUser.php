<?php

class WebUser extends CWebUser
{
	/**
	 * This method will attempt to create a guest user (an empty shell user with just an email address reference).
	 * Will throw a 403 exception if a user exists for that email and has a password.
	 * @param string $email already verified email address.
	 */
	public function createGuestUser($email){
		
		$existing_user = User::model()->find("email = :email", array(":email"=>$email));
		
		if ($existing_user !== null && !Yii::app()->controller->isB2b() && $existing_user->password !== null){
			
			// User already exists and has a password set.
			throw new CHttpException(403,'Your request is invalid.');
			
		}
		
		
		
		$identity=new UserIdentity($email,null);
		
		if ($identity->authenticate())
			$this->login($identity);
		
	}
   
}
?>