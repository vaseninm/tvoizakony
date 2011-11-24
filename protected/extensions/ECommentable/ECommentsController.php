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
        $model = CActiveRecord::model($array['modelname'])->findByPk($array['modelid']);
        $comment = $model->addComment($array['text'], $parent);
        $html = false;
        if ($comment) {
            $html = $this->renderPartial('_item', array(
                'comment' => $comment,
                'owner' => $model,
                    ), true
            );
            HMail::send('К вашему закону на TvoiZakony.ru добавлен комментарий', 'addcommenttolaws', $comment->owner->email, array(
                'model' => $model,
                'comment' => $comment,
            ));
            if ($comment->parent_id > 0) {
                $parentmodel = Comment::model()->findByPk($comment->parent_id);
                HMail::send('К вашему комментарию на TvoiZakony.ru добавлен ответ', 'addcommenttocomment', $parentmodel->owner->email, array(
                    'model' => $model,
                    'comment' => $comment,
                    'parent' => $parentmodel,
                ));
            }
        }

        echo json_encode(array(
            'error' => !$model,
            'html' => $html,
        ));
    }

    public function actionDelete($modelname, $modelid) {
        $model = CActiveRecord::model($modelname)->findByPk($modelid);
        if (Yii::app()->user->checkAccess('moderator')) {
            $comment = $model->deleteComment($_POST['commentid']);
        }
        $html = false;
        if (isset($comment)) {
            $comment->save();
            $html = $this->renderPartial('_item', array(
                'comment' => $comment,
                'owner' => $model,
                    ), true);
            HMail::send('Ваш комментари на TvoiZakony.ru удален', 'deletedcomment', $comment->owner->email, array(
                'model' => $model,
                'comment' => $comment,
            ));
        }
        echo json_encode(array(
            'error' => !$html,
            'html' => $html,
            'divid' => $_POST['divid'],
        ));
    }

}
