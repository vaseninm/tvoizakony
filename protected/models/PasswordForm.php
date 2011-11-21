<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class PasswordForm extends CFormModel
{
	public $password1;
	public $password2;
        
        public $oldpassword;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
                    array('password1, password2, oldpassword', 'required'),
                    array('password1, password2, oldpassword', 'length', 'min'=>6),
                    array('oldpassword', 'isOldPasswordValid'),
                    array('password2', 'compare', 'compareAttribute' => 'password1'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'password1' => 'Новый пароль',
			'password2' => 'Повтор нового пароля',
			'oldpassword' => 'Старый пароль',
		);
	}
        
        public function isOldPasswordValid () {
            $model = Users::model()->findByPk(Yii::app()->user->id);
            if ($model->getPasswordHash($this->oldpassword) != $model->password) {
                $this->addError('oldpassword', 'Предыдущий пароль не верен.');
            }
        }
}
