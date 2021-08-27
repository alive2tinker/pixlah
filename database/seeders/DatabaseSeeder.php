<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();
        $this->call(ScreenSeeder::class);
        $this->call(AttachmentSeeder::class);
        Message::factory(3)->create();
        $this->call(OrderSeeder::class);
    }
}
