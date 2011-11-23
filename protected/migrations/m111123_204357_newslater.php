<?php

class m111123_204357_newslater extends CDbMigration {

    public function safeUp() {
        $this->addColumn('profiles', 'sendnewslatter', 'int(1)');
        $this->update('profiles', array('sendnewslatter'=>1));
    }

    public function down() {
        $this->dropColumn('profiles', 'sendnewslatter');
    }

}