<?php

class m110924_223816_laws_modify extends CDbMigration
{
	public function up()
	{
            $this->addColumn('laws', 'createtime', 'int NOT NULL');
	}

	public function down()
	{
            $this->dropColumn('laws', 'createtime');
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