<?php

class m170607_161409_add_slug_column_to_catmaker_table extends CDbMigration
{
    private $tableName = '{{catmaker}}';

    public function up()
    {
        $this->addColumn($this->tableName,'slug', 'varchar(255) NOT NULL');
        $models = Catmaker::model()->findAll();
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