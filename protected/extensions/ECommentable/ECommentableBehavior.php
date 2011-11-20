<?php

/**
 * Description of ECommentable
 *
 * @author vaseninm
 */
class ECommentableBehavior extends CActiveRecordBehavior {

    public function add($text, $parent = 0) {
        if ($parent > 0) {
            $parentModel = Comments::model()->findByPk($parent);
            if (!$parentModel)
                return false;
            $level = $parentModel->level + 1;
        } elseif ($parent == 0) {
            $level = 0;
        } else {
            return false;
        }

        $comments = new Comments;
        $relation = new CommentRelation;

        $comments->text = $text;
        $comments->parent_id = $parent;
        $comments->level = $level;
        $comments->createtime = time();
        $comments->user_id = Yii::app()->user->id;
        $comments->status = Comments::DEFAULT_STATUS;
        if (!$comments->save())
            return false;

        $relation->comment_id = $comments->id;
        $relation->model_id = $this->owner->primaryKey;
        $relation->model_name = get_class($this->owner);
        if (!$relation->save())
            return false;
        return $comments;
    }

    public function edit($id, $text) {
        $comments = $this->getCommentModel($id);
        if ($comments->user_id != Yii::app()->user->id)
            return false;
        $comments->text = $text;
        return $comments->save();
    }

    public function delete($id) {
        $comments = $this->getCommentModel($id);
        if ($comments->user_id != Yii::app()->user->id)
            return false;
        $comments->status = Comments::STATUS_DELETE;
        return $comments->save();
    }

    public function get() {
        return Comments::model()->tree(array(
                            'condition' => 'relation.model_id = :modelid AND relation.model_name=:modelname',
                            'params' => array(
                                ':modelid' => $this->owner->primaryKey,
                                ':modelname' => get_class($this->owner),
                            ),
                            'with' => array('relation'),
                                ));
    }

    public function addComment($text, $parent = 0) {
        return $this->add($text, $parent);
    }

    public function deleteComment($id) {
        return $this->delete($id);
    }

    public function editComment($id, $text) {
        return $this->edit($id, $text);
    }

    public function getComments() {
        return $this->get();
    }

    public function afterDelete($event) {
        Comments::model()->deleteAll(array(
            'condition' => 'relation.model_id = :modelid AND relation.model_name=:modelname',
            'params' => array(
                ':modelid' => $this->owner->primaryKey,
                ':modelname' => get_class($this->owner),
            ),
            'with' => array('relation'),
        ));
        CommentRelation::model()->deleteAll(array(
            'condition' => 'model_id = :modelid AND model_name=:modelname',
            'params' => array(
                ':modelid' => $this->owner->primaryKey,
                ':modelname' => get_class($this->owner),
            ),
        ));
        parent::afterDelete($event);
    }

    protected function getCommentModel($id) {
        $model = Comments::findByPk($id);
        if (!$model)
            throw new CHttpException(404);
        return $model;
    }

}
