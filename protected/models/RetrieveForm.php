<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RetrieveForm extends CFormModel
{
        public $email;
        
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
                    array('email', 'required'),
                    array('email', 'email'),
                    array('email', 'exist', 'className'=>'Users'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email' => 'E-Mail',
		);
	}
}
