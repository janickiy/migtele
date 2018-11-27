<?php

class m170118_095842_add_availability_setting extends CDbMigration
{
	public function up()
	{
		$setting = new Settings();
		$setting->id = 'set_aviability_in_import';
		$setting->type = 'checkbox';
		$setting->name = 'Возможность проставлять наличие через импорт файлов';
		$setting->value = 'false';
		$setting->sort = 0;
		$setting->hide = 0;
		$setting->save(false);
	}

	public function down()
	{
		Settings::model()->deleteByPk('set_aviability_in_import');
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