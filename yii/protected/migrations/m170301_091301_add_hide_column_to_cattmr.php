<?php

class m170301_091301_add_hide_column_to_cattmr extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{cattmr}}','hide', 'TINYINT NOT NULL DEFAULT 0');
	}

	public function down()
	{
		$this->dropColumn('{{cattmr}}','hide');
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