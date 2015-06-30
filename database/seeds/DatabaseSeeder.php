<?php

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Models\Event;
use Models\Role;
use Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('UgoTableSeeder');
    }

}

class UgoTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('user')->truncate();
        DB::table('role')->truncate();
        DB::table('role_user')->truncate();
        DB::table('event')->truncate();
        DB::table('exp_level')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Factory::create();

        $uQ = new User();
        $uQ->login = 'quentin';
        $uQ->password = Hash::make('quentin');
        $uQ->email = 'quentin@mail.com';
        $uQ->streaming = 1;
        $uQ->twitch_channel = 'quentin';
        $uQ->save();

        for ($i = 0; $i < 25; $i++) {
            $username = $faker->unique()->username;
            $u = new User();
            $u->login = $username;
            $u->email = $faker->unique()->freeEmail;
            $u->password = Hash::make($username);
            $u->streaming = 0;
            $u->twitch_channel = $i;
            $u->save();
        }

        $this->command->info('Users created');

        $admin = new Role();
        $admin->title = 'admin';
        $admin->save();

        $streamer = new Role();
        $streamer->title = 'streamer';
        $streamer->save();

        $this->command->info('Roles created');
        $uQ->roles()->attach($admin->role_id);
        $uQ->roles()->attach($streamer->role_id);
        $this->command->info('Roles attached');

        $event = new Event();
        $event->title = 'Hugo';
        $event->start = '2015-06-26T12:30:00+02:00';
        $event->end = '2015-06-26T15:30:00+02:00';
        $event->allDay = 'false';
        $event->color = '#FF0000';
        $event->timezone = '+02:00';
        $event->save();
        $this->command->info('Test event created');
    }
}
