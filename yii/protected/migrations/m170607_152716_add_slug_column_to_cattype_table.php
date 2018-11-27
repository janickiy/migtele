<?php

class m170607_152716_add_slug_column_to_cattype_table extends CDbMigration
{
	private $tableName = '{{cattype}}';

    public function up()
	{
        $this->addColumn($this->tableName,'slug', 'varchar(255) NOT NULL');
        $models = Cattype::model()->findAll();
        /**@var $models Cattype[]*/
        foreach($models as $model){
            $model->slug = Helpers::str2url($model->name);
            $model->save(false);
        }
	}

	public function down()
	{
		$this->dropColumn($this->tableName, 'slug');
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