<?php

class m170117_155712_add_importNew_column_to_goods extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{goods}}','importNew','tinyint DEFAULT 0');

	}

	public function down()
	{
		$this->dropColumn('{{goods}}','importNew');
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