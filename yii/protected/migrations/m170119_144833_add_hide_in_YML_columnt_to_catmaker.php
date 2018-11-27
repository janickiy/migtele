<?php

class m170119_144833_add_hide_in_YML_columnt_to_catmaker extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{catmaker}}','hide_in_YML','BOOLEAN NOT NULL DEFAULT 0');
	}

	public function down()
	{
		$this->dropColumn('{{catmaker}}','hide_in_YML');
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