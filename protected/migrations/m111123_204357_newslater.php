<?php

class m111123_204357_newslater extends CDbMigration {

    public function safeUp() {
        $this->addColumn('profiles', 'sendnewsletter', 'int(1)');
        $this->update('profiles', array('sendnewsletter'=>1));
    }

    public function down() {
        $this->dropColumn('profiles', 'sendnewsletter');
    }

}