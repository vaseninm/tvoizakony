<?php

class UserController extends Controller {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            array(
                'ext.filters.YXssFilter',
                'clean' => '*',
                'tags' => 'none',
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
                'actions' => array('edit', 'logout', 'changepassword'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('admin', 'setRole'),
                'roles' => array('administrator'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function beforeAction($view) {
        parent::beforeAction($view);
        Yii::app()->breadCrumbs->setCrumb('Пользователь', array('/user/profile'));
        return true;
    }

    public function actionChangePassword() {
        $model = new PasswordForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'changepassword-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['PasswordForm'])) {
            $model->attributes = $_POST['PasswordForm'];
            if ($model->validate()) {
                $user = Users::model()->findByPk(Yii::app()->user->id);
                $user->password = $user->getPasswordHash($model->password1);
                if ($user->save()) {
                    EUserFlash::setSuccessMessage('Пароль успешно изменен');
                    $this->redirect(array('/user/profile'));
                }
            }
        }

        $this->render('changepassword', array('model' => $model));
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
        $model->sendnewslatter = $user->profile->sendnewslatter;
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

                HMail::send('Регистрация на TvoiZakony.ru', 'registration', $model->email, array(
                    'user' => Users::model()->findByPk($user->id),
                ), true);

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
                $password = substr(md5(rand() . 'sDfFe' . rand()), 3, 13);
                $user = Users::model()->find('email = :email', array(':email' => $model->email));
                $user->password = $user->getPasswordHash($password);
                if ($user->save()) {
                    HMail::send('Восстановление пароля на TvoiZakony.ru', 'retrieve', $model->email, array(
                        'user' => $user,
                        'password' => $password,
                    ), true);
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

    public function actionSetRole() {
        $model = Users::model()->findByPk($_POST['item']);
        $model->role = $_POST['value'];
        $model->save();
    }

}