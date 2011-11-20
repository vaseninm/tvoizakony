<?php

class m111112_064907_comments extends CDbMigration {

    public function safeUp() {
        $this->createTable('comments', array(
            'id' => 'pk',
            'text' => 'text',
            'createtime' => 'int',
            'parent_id' => 'int',
            'level' => 'int',
            'user_id' => 'int',
            'status' => 'int',
        ));
        $this->createTable('comment_relation', array(
            'id' => 'pk',
            'model_id' => 'int',
            'comment_id' => 'int',
            'model_name' => 'string',
        ));
    }

    public function safeDown() {
        $this->dropTable('comments');
        $this->dropTable('comment_relation');
    }

}