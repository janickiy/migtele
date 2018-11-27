<?php

class m170118_124440_create_clickCount_column_to_good extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{goods}}','clickCount','INT(11) DEFAULT 0');
		$this->addColumn('{{catmaker}}','clickCount','INT(11) DEFAULT 0');
		$this->addColumn('{{cattype}}','clickCount','INT(11) DEFAULT 0');
		$this->addColumn('{{otr}}','clickCount','INT(11) DEFAULT 0');
		$this->addColumn('{{cattmr}}','clickCount','INT(11) DEFAULT 0');
		$this->addColumn('{{catrazdel}}','clickCount','INT(11) DEFAULT 0');
	}

	public function down()
	{
		$this->dropColumn('{{goods}}','clickCount'); //+
		$this->dropColumn('{{catmaker}}','clickCount');
		$this->dropColumn('{{cattype}}','clickCount');
		$this->dropColumn('{{otr}}','clickCount');
		$this->dropColumn('{{cattmr}}','clickCount'); //+
		$this->dropColumn('{{catrazdel}}','clickCount'); //+
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