<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RegForm extends CFormModel
{
	public $username;
	public $password1;
	public $password2;
    public $email;
        
    public $firstname;
    public $lastname;
        
        public $role = 'writer';
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
                    array('username, password1, password2, email, firstname, lastname', 'required'),
                    array('email', 'email'),
                    array('password1, password2', 'length', 'min'=>6),
                    array('password2', 'compare', 'compareAttribute' => 'password1'),
                    array('username', 'match', 'pattern'=>'/^[a-z0-9_]+$/i', 'message'=>'{attribute} может содержать только латинские буквы, цифры и знаки _.'),
                    array('firstname, lastname', 'safe'),
                    array('email,username', 'unique', 'className'=>'Users')
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'Логин',
			'password1' => 'Пароль',
			'password2' => 'Пароль',
			'email' => 'E-Mail',
			'firstname' => 'Имя',
			'lastname' => 'Фамилия',
		);
	}
}
