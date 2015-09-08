<?php

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Models\Event;
use Models\ExpLevel;
use Models\Role;
use Models\User;
use Webtv\ExperienceManager;
use Webtv\StreamingUserService;

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
        $uQ->pseudo = 'QsAnakrose';
        $uQ->password = Hash::make('quentin');
        $uQ->email = 'quentin@mail.com';
        $uQ->streaming = 1;
        $uQ->twitch_channel = 'riotgames';
        $uQ->save();

        $data = [];
        for ($i = 0; $i < 110; $i++) {

            $username = $faker->unique()->username;

            $data[] = [
                'login'    => $username,
                'pseudo'   => $username,
                'email'    => $faker->unique()->freeEmail,
                'password' => Hash::make($username)
            ];
        }
        User::insert($data);

        $this->command->info('Users created');

        $admin = new Role();
        $admin->title = 'admin';
        $admin->save();

        $streamer = new Role();
        $streamer->title = 'streamer';
        $streamer->save();

        $this->command->info('Roles created');
        $uQ->becomeAdmin();
        $uQ->becomeStreamer();

        for ($i = 2; $i < 13; $i++) {
            $u = User::find($i);
            $u->becomeStreamer();
            $u->twitch_channel = $i;
            $u->description = $u->login . 'lorem ipsum dolor. Lol. lorem ipsum dolor. Lol. lorem ipsum dolor. Lol. lorem ipsum dolor. Lol. lorem ipsum dolor. Lol. lorem ipsum dolor. Lol.';
            $rand = rand(0, 2);
            if ($rand == 0) {
                $u->streaming = 1;
            }
            else {
                $u->streaming = 0;
            }
            /*
            $avatarManager = new AvatarManager();
            $intervManager = $avatarManager->getImgManager();
            $width = $avatarManager->getAvatarWidth();
            $color = substr(md5(rand()), 0, 6);
            $intervManager->canvas($width, $width, $color);
            */
            $u->save();
        }
        $su = new StreamingUserService();
        $su->update();

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

        $expManager = new ExperienceManager();
        $data = $expManager->generateExperienceSystem();
        ExpLevel::insert($data);
        $this->command->info('Experience system initialized');

    }
}
