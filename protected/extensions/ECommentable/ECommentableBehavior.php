<?php

/**
 * Description of ECommentable
 *
 * @author vaseninm
 */
class ECommentableBehavior extends CActiveRecordBehavior {

    public $allowedTags = array('a', 'img', 'blockquote', 'b', 'i', 's');
    
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

        $comments->text = $this->stripTags($text);
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

    public function edit($id, $text, $save = true) {
        $comments = $this->getCommentModel($id);
        $comments->text = $this->stripTags($text);
        if ($save && !$comments->save()) {
            return false;
        }
        return $comments;
    }

    public function delete($id, $save = true) {
        $comments = $this->getCommentModel($id);
        $comments->status = Comments::STATUS_DELETE;
        if ($save && !$comments->save()) {
            return false;
        }
        return $comments;
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
        $model = Comments::model()->findByPk($id);
        if (!$model)
            throw new CHttpException(404);
        return $model;
    }
    
    protected function stripTags($text) {
        $tags = '';
        foreach ($this->allowedTags as $tag) {
            $tags .= "<$tag>";
        }
        return strip_tags($text, $tags);
    }

}
