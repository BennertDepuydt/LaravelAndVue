<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //permissions
        DB::table('permissions')->insert([
            'slug' => 'edit-users',
            'name' => 'Edit Users',
        ]);

        DB::table('permissions')->insert([
            'slug' => 'create-tasks',
            'name' => 'Create Tasks',
        ]);

        //roles
        DB::table('roles')->insert([
            'slug' => 'admin',
            'name' => 'Admin',
        ]);

        DB::table('roles')->insert([
            'slug' => 'user',
            'name' => 'User',
        ]);

        //roles_permissions
        DB::table('roles_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 1,
        ]);
        DB::table('roles_permissions')->insert([
            'role_id' => 2,
            'permission_id' => 2,
        ]);

        //user admin
        DB::table('users')->insert([
            'realfirstname' => Str::random(10),
            'realsurname' => Str::random(10),
            'gamefirstname' => Str::random(10),
            'gamesurname' => Str::random(10),
            'discordname' => Str::random(10),
            'steamname' => Str::random(10),
            'email' => 'admin@gmail.com',
            'birthdate' => new DateTime("2015-12-31 00:00:00"),
            'password' => Hash::make('Azerty123'),
        ]);
        DB::table('users_roles')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);
        DB::table('users_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 1
        ]);


        //user default
        DB::table('users')->insert([
            'realfirstname' => Str::random(10),
            'realsurname' => Str::random(10),
            'gamefirstname' => Str::random(10),
            'gamesurname' => Str::random(10),
            'discordname' => Str::random(10),
            'steamname' => Str::random(10),
            'email' => 'user@gmail.com',
            'birthdate' => new DateTime("2015-12-31 00:00:00"),
            'password' => Hash::make('Azerty123'),
        ]);
        DB::table('users_roles')->insert([
            'user_id' => 2,
            'role_id' => 2
        ]);
        DB::table('users_permissions')->insert([
            'user_id' => 2,
            'permission_id' => 2
        ]);

        //car_categories
        DB::table('car_categories')->insert([
            'name' => 'super'
        ]);
        DB::table('car_categories')->insert([
            'name' => 'suv'
        ]);
        DB::table('car_categories')->insert([
            'name' => 'compact'
        ]);
        DB::table('car_categories')->insert([
            'name' => 'offroad'
        ]);
        DB::table('car_categories')->insert([
            'name' => 'coupes'
        ]);
        DB::table('car_categories')->insert([
            'name' => 'motorcycles'
        ]);
        DB::table('car_categories')->insert([
            'name' => 'sports'
        ]);
        DB::table('car_categories')->insert([
            'name' => 'sportsclassics'
        ]);
        DB::table('car_categories')->insert([
            'name' => 'vans'
        ]);
        DB::table('car_categories')->insert([
            'name' => 'muscle'
        ]);
        DB::table('car_categories')->insert([
            'name' => 'sedans'
        ]);


        //cars
        DB::table('cars')->insert([
            'name' => 'Lamborghini Urus',
            'year' => '2018',
            'price' => '275 000',
            'modelname' => 'urus',
            'car_categories_id' => 2,
            'imgUrl' => "https://i.imgur.com/KKcrGA5.png"
        ]);
        DB::table('cars')->insert([
            'name' => 'Toyota Supra GR',
            'year' => '2020',
            'price' => '200 000',
            'modelname' => 'tsgr20',
            'car_categories_id' => 1,
            'imgUrl' => "https://i.imgur.com/p0qcNHF.png"
        ]);
        DB::table('cars')->insert([
            'name' => 'Audi RS7',
            'year' => '2017',
            'price' => '200 000',
            'modelname' => 'rs72017',
            'car_categories_id' => 7,
            'imgUrl' => "https://i.imgur.com/eQzXzQT.png"
        ]);
        DB::table('cars')->insert([
            'name' => 'Volvo XC90',
            'year' => '2017',
            'price' => '100 000',
            'modelname' => 'xc90',
            'car_categories_id' => 2,
            'imgUrl' => "https://i.imgur.com/Ga48k8R.png"
        ]);
        DB::table('cars')->insert([
            'name' => 'Honda Civic Type-R',
            'year' => '2018',
            'price' => '75 000',
            'modelname' => 'FK8',
            'car_categories_id' => 11,
            'imgUrl' => "https://i.imgur.com/T40pWzS.png"
        ]);
        DB::table('cars')->insert([
            'name' => 'Chevrolet Camaro ZL1',
            'year' => '2017',
            'price' => '200 000',
            'modelname' => 'camaross',
            'car_categories_id' => 5,
            'imgUrl' => "https://i.imgur.com/46UelM2.png"
        ]);

        //tickets
        DB::table('tickets')->insert([
            'title' => 'test1',
            'msg' => 'test2',
            'status' => 'open',
        ]);
        DB::table('tickets')->insert([
            'title' => 'test2',
            'msg' => 'test2',
            'status' => 'resolved',
        ]);

        //organizations
        DB::table('organizations')->insert([
            'name' => 'ANWB',
            'description' => "Als ANWB-er help je de mensen die autoproblemen hebben, weer snel op weg. Van een warm gelopen V-snaar tot en met een kapotte accu. Jij bent diegene die de mensen weer op weg helpt.",
            'imgUrl' => "https://i.imgur.com/Khjjgb7.png"
            ]);
        DB::table('organizations')->insert([
            'name' => 'Politie',
            'description' => "Solliciteer nu als politieagent binnen GravenStad en help bewoners met verschillende soorten problemen. Van bankovervallen tot en met aanrijdingen, jij kan de mensen helpen en aanhouden als het nodig is.",
            'imgUrl' => "https://i.imgur.com/QwYHWXL.png"
        ]);
        DB::table('organizations')->insert([
            'name' => 'Ambulance',
            'description' => "Als ambulance medewerker, verzorg jij de mensen die dit nodig hebben. Je moet ook sterk in je schoenen staan",
            'imgUrl' => "https://i.imgur.com/eMYxQzO.png"
        ]);

        //soliciaties
        DB::table('jobs')->insert([
            'experience' => true,
            'mic' => false,
            'onlinetime' => 11,
            'playtime' => 50,
            'description' => 'Ik wil graag bij jullie komen werken...',
            'organization_id' => 1
        ]);

        //events
        DB::table('events')->insert([
            'title' => "Car Event",
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris at nisl quis metus eleifend malesuada et quis risus. Morbi volutpat in nulla nec pellentesque. Vestibulum lorem sapien, congue at arcu lacinia, mattis molestie dui. In mollis, sapien quis consectetur viverra, sem risus cursus dolor, sed malesuada mauris justo non erat. Quisque laoreet, enim id imperdiet tempus, urna ligula interdum nisl, at tristique nisl nunc eu enim. Nullam luctus finibus turpis, eget viverra mi tristique et. Aliquam erat volutpat. Cras et neque at metus sollicitudin semper. Nam quam dolor, molestie in lobortis quis, lacinia eget eros. In a ipsum purus. Integer pretium vehicula dui et iaculis. Fusce sodales feugiat est id dictum.Nam consectetur tellus sit amet erat tristique, eu ultricies est rutrum. Ut ac cursus mi, eget gravida purus. Suspendisse sit amet velit sodales, dapibus erat a, aliquet ligula. Nulla a sollicitudin nisi, tincidunt dignissim orci. Nam pretium ipsum nec dolor luctus, vel blandit augue congue. Donec euismod leo vitae pellentesque euismod. Fusce eget risus pulvinar, scelerisque felis id, iaculis massa. Morbi sit amet ultricies diam. Phasellus efficitur lorem erat, vitae sodales sem maximus non. Ut nec tellus id massa blandit ultrices. Vivamus ipsum mi, tempus at purus ac, tincidunt mattis neque. In finibus libero nec nisi ullamcorper porta. Ut enim tellus, feugiat ac purus in, lobortis efficitur nisl. Proin vestibulum blandit ipsum. Nullam metus neque, molestie eget dui at, tempor aliquam dui.",
        ]);


        //donaties
        DB::table('donaties')->insert([
            'type' => "money",
            'user_id' => 2,
        ]);
        DB::table('donaties')->insert([
            'type' => "car",
            'user_id' => 2,
        ]);
        DB::table('donaties')->insert([
            'type' => "other",
            'user_id' => 2,
        ]);
    }


}
