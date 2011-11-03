<?php

class m110924_195655_create_table extends CDbMigration
{
	protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8';
        
        public function up()
	{
            $this->createTable('users', array(
                'id' => 'pk',
                'username' => 'string NOT NULL',
                'password' => 'varchar(64) NOT NULL',
                'email' => 'string NOT NULL',
                'role' => 'string NOT NULL',
            ));
            $this->createTable('profiles', array(
                'id' => 'pk',
                'firstname' => 'string',
                'lastname' => 'string',
                'user_id' => 'int NOT NULL',
            ));
            $this->createTable('laws', array(
                'id' => 'pk',
                'title' => 'string NOT NULL',
                'desc' => 'text NOT NULL',
                'user_id' => 'int NOT NULL',
            ));
	}

	public function down()
	{
            $this->dropTable('users');
            $this->dropTable('profiles');
            $this->dropTable('laws');
	}

}