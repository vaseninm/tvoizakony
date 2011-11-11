<?php

class LawsController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'main';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl',
            'ajaxOnly + setStatus,plusOne',
            array(
                'ext.filters.YXssFilter',
                'clean' => '*',
                'tags' => 'none',
                'actions' => 'all'
            ),
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'main', 'vote'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'delete'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'setstatus'),
                'roles' => array('moderator'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function beforeAction() {
        //parent::beforeAction();
        Yii::app()->breadCrumbs->setCrumb('Законопроекты', array('/laws/index', 'rating' => 0));
        return true;
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        if (!$model->approve && !Yii::app()->user->checkAccess('moderator') && !($model->user_id == Yii::app()->user->id))
            throw new CHttpException(404, 'The requested page does not exist.');
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Laws;

        $this->performAjaxValidation($model);

        if (isset($_POST['Laws'])) {
            $model->attributes = $_POST['Laws'];
            $model->user_id = Yii::app()->user->id;
            $model->createtime = time();
            $model->approve = 0;
            if ($model->save()) {
                EUserFlash::setSuccessMessage('Закон успешно добавлен и отправлен на проверку модератору.');
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (!$model->isEdited())
            throw new CHttpException(500);

        $this->performAjaxValidation($model);

        if (isset($_POST['Laws'])) {
            $model->attributes = $_POST['Laws'];
            $model->approve = (int) Yii::app()->user->checkAccess('moderator');
            if ($model->save()) {
                EUserFlash::setSuccessMessage('Закон успешно отредактирован');
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if ($model->user_id != Yii::app()->user->id && !Yii::app()->user->checkAccess('moderator'))
            throw new CHttpException(500);
        $error = !$model->delete();
        if (!isset($_POST['ajax']) && !isset($_GET['ajax'])) {
            EUserFlash::setSuccessMessage('Закон успешно удален');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/laws/index'));
        }
        echo json_encode(array(
            'error' => $error,
            'params' => array(
                'id' => isset($_POST['id']) ? $_POST['id'] : '',
            ),
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex($rating = false, $user = false, $nonapprove = false) {
        $isMain = false;
        $criteria = new CDbCriteria;
        if (isset($_POST['search'])) {
            $criteria->addSearchCondition('`title`', $_POST['search']);
            $criteria->addSearchCondition('`desc`', $_POST['search'], NULL, 'OR');
        }
        if ($rating) {
            $criteria->compare('cache_rate', '>=' . $rating);
        }
        if ($user) {
            $criteria->with = array('owner');
            $criteria->together = 1;
            $criteria->compare('owner.username', $user);
        }
        if ($nonapprove && (Yii::app()->user->checkAccess('moderator') || ($user && $user == Yii::app()->user->name))) {
            $criteria->compare('approve', 0);
        } else {
            $criteria->compare('approve', 1);
        }
        $dataProvider = new CActiveDataProvider('Laws', array(
                    'criteria' => $criteria,
                    'sort' => array(
                        'defaultOrder' => 'createtime DESC',
                        'attributes' => array(
                            'createtime',
                            'cache_rate',
                        ),
                    ),
                ));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'isMain' => $isMain,
        ));
    }

    public function actionMain() {
        $isMain = true;
        $criteria = new CDbCriteria;
        $criteria->compare('approve', 1);
        $criteria->compare('cache_rate', '>=' . Laws::MAIN_PAGE_RATE);
        $dataProvider = new CActiveDataProvider('Laws', array(
                    'criteria' => $criteria,
                    'sort' => array(
                        'defaultOrder' => 'createtime DESC',
                        'attributes' => array(
                            'createtime',
                            'cache_rate',
                        ),
                    ),
                ));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'isMain' => $isMain,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Laws('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Laws']))
            $model->attributes = $_GET['Laws'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionVote($law) {
        if ($_POST['do'] == 'plus') {
            $rate = 1;
        } elseif ($_POST['do'] == 'minus') {
            $rate = -1;
        } else {
            throw new CHttpException(500);
        }
        $model = new Rating;
        $model->user_id = Yii::app()->user->id;
        $model->law_id = $law;
        $model->type = $rate;
        $laws = Laws::model()->findByPk($law);
        $laws->cache_rate += $rate;
        $error = 0;
        if (Yii::app()->user->isGuest) {
            $error = 3;
        }
        if ($laws->user_id == $model->user_id) {
            $error = 1;
        }
        if (!$error && !($model->save() && $laws->save() )) {
            $error = 2;
        }
        if ($error) {
            $laws->cache_rate -= $rate;
        }
        echo json_encode(array(
            'error' => $error,
            'rating' => $laws->cache_rate,
            'params' => array(
                'id' => isset($_POST['id']) ? $_POST['id'] : '',
            ),
        ));
    }

    public function actionSetStatus($law, $status) {
        $laws = Laws::model()->findByPk($law);
        $laws->approve = $status;
        $error = !$laws->save();
        echo json_encode(array(
            'error' => $error,
            'approve' => $laws->approve,
            'params' => array(
                'id' => isset($_POST['id']) ? $_POST['id'] : '',
            ),
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Laws::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'laws-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
