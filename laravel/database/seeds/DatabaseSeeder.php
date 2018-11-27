<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DeliveryMethodSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(MailTemplatesSeeder::class);
        $this->call(PageSeeder::class);
    }
}
