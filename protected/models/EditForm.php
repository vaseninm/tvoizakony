<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class EditForm extends CFormModel
{       
        public $firstname;
        public $lastname;
        public $avatar;
        public $sendnewsletter;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
                    array('firstname, lastname', 'required'),
                    array('firstname, lastname', 'safe'),
                    array('sendnewsletter', 'boolean'),
                    array('avatar', 'file', 'types' => 'png, gif, jpg', 'allowEmpty' => true),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'avatar' => 'Фото',
			'firstname' => 'Имя',
			'lastname' => 'Фамилия',
		);
	}
}
