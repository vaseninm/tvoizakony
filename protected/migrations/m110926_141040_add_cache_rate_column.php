<?php

class m110926_141040_add_cache_rate_column extends CDbMigration {

    public function up() {
        $this->addColumn('laws', 'cache_rate', 'integer');
    }

    public function down() {
        $this->dropColumn('laws', 'cache_rate');
    }
}