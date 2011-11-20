<?php

/**
 * Description of ECommentableWidget
 *
 * @author vaseninm
 */
class ECommentableWidget extends CWidget {

    /**
     * Модель с выборкой. !CActeveRecord::isNewRecord
     * @var CActiveRecord $model
     */
    public $model;

    public function init() {
        $css = Yii::app()->assetManager->publish(Yii::getPathOfAlias('ext.ECommentable.assets') . '/ecommentable.css');
        $js = Yii::app()->assetManager->publish(Yii::getPathOfAlias('ext.ECommentable.assets') . '/ecommentable.js');
        Yii::app()->clientScript->registerCssFile($css);
        Yii::app()->clientScript->registerScriptFile($js);       
        parent::init();
    }

    public function run() {
        if (!isset($this->model))
            throw new CHttpException(500, 'Model is not exist');
        if ($this->model->isNewRecord)
            throw new CHttpException(500, 'Owner model not new');
        $comments = $this->model->getComments();
        $this->render('list', array(
            'comments' => $comments,
            'owner' => $this->model,
            'model' => new Comments(),
        ));
    }

}
