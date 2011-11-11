<?php

class m111104_050950_add_rate_type extends CDbMigration
{
	public function up()
	{
            $this->addColumn('rating', 'type', 'integer');
            $this->update('rating', array('type'=>'+1'));
	}

	public function down()
	{
            $this->dropColumn('rating', 'type');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}