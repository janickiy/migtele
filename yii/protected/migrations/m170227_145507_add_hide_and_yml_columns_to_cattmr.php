<?php

class m170227_145507_add_hide_and_yml_columns_to_cattmr extends CDbMigration
{
	public function up()
	{
//		$this->addColumn('{{cattmr}}','hide', 'TINYINT NOT NULL DEFAULT 0');
		$this->addColumn('{{cattmr}}','hide_in_YML', 'TINYINT NOT NULL DEFAULT 0');
	}

	public function down()
	{
//		$this->dropColumn('{{cattmr}}','hide');
		$this->dropColumn('{{cattmr}}','hide_in_YML');
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