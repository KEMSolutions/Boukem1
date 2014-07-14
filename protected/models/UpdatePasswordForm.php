<?php

/**
 * UpdatePasswordForm class.
 * UpdatePasswordForm is the data structure for keeping
 * password update form date. It is used by the 'updatePassword' action of 'AccountController'.
 */
class UpdatePasswordForm extends CFormModel
{
	public $new_password;
	public $old_password;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('new_password, old_password', 'required'),
			array('new_password', 'length', 'min'=>4),
			// password needs to be authenticated
			array('old_password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'old_password'=>Yii::t("app", "Mot de passe actuel"),
			'new_password'=>Yii::t("app", "Nouveau mot de passe"),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			if(!CPasswordHelper::verifyPassword($this->old_password, Yii::app()->user->user->password))
				$this->addError('old_password',Yii::t("app","Le mot de passe actuel entré est incorrect."));
		}
	}

}
