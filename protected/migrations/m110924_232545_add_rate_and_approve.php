<?php

class m110924_232545_add_rate_and_approve extends CDbMigration
{
	public function up()
	{
            $this->addColumn('laws','approve', 'boolean');
            $this->createTable('rating', array(
                'id'=>'pk',
                'user_id'=>'int NOT NULL',
                'law_id'=>'int NOT NULL',
            ));
	}

	public function down()
	{
            $this->dropColumn('laws', 'approve');
            $this->dropTable('rating');
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