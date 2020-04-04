<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $manager = factory(\App\User::class)->states('manager')->create();
        factory(\App\User::class, 35)->create()->each(function ($user) use ($manager) {
            factory(\App\Application::class, random_int(0, 10))->create([
                'user_id' => $user->id,
                'manager_id' => random_int(0, 10) > 8 ? $manager->id : null
            ])->each(function ($application) use ($user, $manager){
                for ($i=0; $i < random_int(0, 25); $i++) {
                    factory(\App\Message::class, 1)->create([
                        'user_id' => rand(0, 10) > 5 ? $user->id : $manager->id,
                        'application_id' => $application->id
                    ]);
                }
            });
        });
}
}
