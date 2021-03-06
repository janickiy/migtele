<?php

class m170608_132358_add_slug_column_to_otr_table extends CDbMigration
{
    private $tableName = '{{otr}}';

    public function up()
    {
        $this->addColumn($this->tableName,'slug', 'varchar(255) NOT NULL');
        $models = Otr::model()->findAll();
        /**@var $models Otr[]*/
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