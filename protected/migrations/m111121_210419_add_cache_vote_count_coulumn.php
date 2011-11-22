<?php

class m111121_210419_add_cache_vote_count_coulumn extends CDbMigration
{
    public function up() {
        $this->addColumn('laws', 'cache_vote_count', 'integer');
        $laws = Laws::model()->findAll();
        foreach ($laws as $law) {
            $law->cache_vote_count = Rating::model()->count('law_id=:id', array(':id'=>$law->id));
            $law->save();
        }
    }

    public function down() {
        $this->dropColumn('laws', 'cache_vote_count');
    }
}