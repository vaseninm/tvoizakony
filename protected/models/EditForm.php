<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class EditForm extends CFormModel
{
	public $password1;
	public $password2;
        
        public $firstname;
        public $lastname;
        public $avatar;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
                    array('firstname, lastname', 'required'),
                    array('password1, password2', 'length', 'min'=>6),
                    array('password2', 'compare', 'compareAttribute' => 'password1'),
                    array('firstname, lastname', 'safe'),
                    array('avatar', 'file', 'types' => 'png, gif, jpg', 'allowEmpty' => true),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'password1' => 'Пароль',
			'password2' => 'Пароль',
			'avatar' => 'Фото',
			'firstname' => 'Имя',
			'lastname' => 'Фамилия',
		);
	}
}
