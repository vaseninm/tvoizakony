<?php

class UserController extends Controller {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
			array(
                'ext.filters.YXssFilter',
                'clean'   => '*',
                'tags'    => 'none',
                'actions' => 'all'
            ),
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('registration', 'login', 'profile', 'retrieve'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('edit', 'logout'),
                'users' => array('@'),
            ),
			array('allow',
				'actions' => array('admin', 'setRole'),
				'roles'=>array('administrator'),
			),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
	
	public function beforeAction () {
		//parent::beforeAction();
		Yii::app()->breadCrumbs->setCrumb('Пользователь', array('/users/profile'));
		return true;
	}

    public function actionEdit() {
        $model = new EditForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'edit-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['EditForm'])) {
            $model->attributes = $_POST['EditForm'];
            if ($model->validate()) {
                if (!empty($model->password1)) {
                    $user = Users::model()->findByPk(Yii::app()->user->id);
                    $user->password = $user->getPasswordHash($model->password1);
                    if (!$user->save())
                        throw new CHttpException(500, "Unknown Error");
                }
                $profile = Profiles::model()->find('user_id = :user', array(':user' => Yii::app()->user->id));
                $profile->attributes = $model->attributes;
				
                if (isset($_FILES['EditForm'])) {
                    $_FILES['Profiles'] = $_FILES['EditForm'];
                    CUploadedFile::reset();
                }
                if (!$profile->save())
                    throw new CHttpException(500, "Unknown Error");
				EUserFlash::setSuccessMessage('Профиль успешно отредактирован');
                $this->redirect(array('/user/profile'));
            }
        }

        $user = Users::model()->findByPk(Yii::app()->user->id);
        $model->firstname = $user->profile->firstname;
        $model->lastname = $user->profile->lastname;
        $this->render('edit', array(
            'model' => $model,
        ));
    }

    public function actionProfile($username = false) {
        $this->layout = '//layouts/column2';
        if (!$username)
            $username = Yii::app()->user->name;
        $model = Users::model()->find('username = :username', array(
            ':username' => $username,
                ));
        if (!$model)
            throw new CHttpException(404, 'User not found.');
        $this->render('profile', array(
            'model' => $model
        ));
    }

    public function actionLogin() {
        $model = new LoginForm;


        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
				EUserFlash::setSuccessMessage('Вы успешно авторизованы.');
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $this->render('login', array('model' => $model));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
		EUserFlash::setSuccessMessage('Вы успешно вышли.');
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionRegistration() {
        $model = new RegForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'reg-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['RegForm'])) {
            $model->attributes = $_POST['RegForm'];
            if ($model->validate()) {
                $user = new Users;
                $user->attributes = $model->attributes;
                $user->password = $user->getPasswordHash($model->password1);
                if (!$user->save())
                    throw new CHttpException(500, "Unknown Error");
                $profile = new Profiles();
                $profile->attributes = $model->attributes;
                $profile->user_id = $user->id;
                if (!$profile->save())
                    throw new CHttpException(500, "Unknown Error");
				$message = new YiiMailMessage;
                $message->subject = 'Регистрация на TvoiZakony.ru';
				$message->view = 'registration';
				$message->data['username'] = $user->username;
                $message->setBody();
                $message->addTo($model->email);
                $message->from = Yii::app()->params['adminEmail'];
                Yii::app()->mail->send($message);
                EUserFlash::setSuccessMessage('Вы успешно зарегистрировались.');
				$this->redirect(array('user/login'));
            }
        }
        $this->render('registration', array('model' => $model));
    }

    public function actionRetrieve() {
        $model = new RetrieveForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'retrieve-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['RetrieveForm'])) {
            $model->attributes = $_POST['RetrieveForm'];

            if ($model->validate()) {
                $password = substr( md5(rand() . 'sDfFe' . rand()), 3, 13);
                $user = Users::model()->find('email = :email', array(':email' => $model->email));
                $user->password = $user->getPasswordHash($password);
                if ($user->save()) {
                    $message = new YiiMailMessage;
                    $message->subject = 'Восстановление пароля на TvoiZakony.ru';
					$message->view = 'retrieve';
					$message->data['password'] = $password;
                    $message->setBody();
                    $message->addTo($model->email);
                    $message->from = Yii::app()->params['adminEmail'];
                    Yii::app()->mail->send($message);
					EUserFlash::setSuccessMessage('Новый пароль отправлен на Ваш e-mail.');
					$this->redirect(array('/user/login'));
                }
            }
        }
        $this->render('retrieve', array(
            'model' => $model,
        ));
    }

	
	public function actionAdmin() {
        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Users']))
            $model->attributes = $_GET['Users'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }
	
	public function actionSetRole () {
		$model = Users::model()->findByPk($_POST['item']);
		$model->role = $_POST['value'];
		$model->save();
	}
}