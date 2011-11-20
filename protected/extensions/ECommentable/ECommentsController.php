<?php

class ECommentsController extends CExtController {

    public function filters() {
        return array(
            'accessControl',
            'ajaxOnly',
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
            //array('allow', // allow all users to perform 'index' and 'view' actions
            //    'actions' => array('get'),
            //    'users' => array('*'),
            //),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('add', 'edit'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('delete'),
                'roles' => array('moderator'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionAdd() {
        parse_str($_POST['form'], $array);
        $parent = isset($array['parent']) ? $array['parent'] : 0;
        $model = CActiveRecord::model($array['modelname'])
                ->findByPk($array['modelid'])
                ->addComment($array['text'], $parent);
        $html = false;
        if ($model) {
            $html = $this->renderPartial('_item', array(
                'comment' => $model
                    ), true);
        }

        echo json_encode(array(
            'error' => !$model,
            'html' => $html,
        ));
    }

    public function actionEdit() {
        echo json_encode(array(
            'error' =>
                    CActiveRecord::model($_POST['modelname'])
                    ->findByPk($_POST['modelid'])
                    ->editComment($_POST['commentid'], $_POST['text'])
        ));
    }

    public function actionDelete() {
        echo json_encode(array(
            'error' =>
                    CActiveRecord::model($_POST['modelname'])
                    ->findByPk($_POST['modelid'])
                    ->deleteComment($_POST['commentid'])
        ));
    }

}
