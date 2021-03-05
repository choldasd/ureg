<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Johnadm Doeadm",
            'email' => 'johnad@gmail.com',
            'phone' => '9876543210',
            'street_address' => '2359  Tavern Place',
            'city' => 'Littleton',
            'state' => 'Colorado',
            'zip' => '80123',
            'type' => "Admin",
            'password' => bcrypt('admin@123'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);
        DB::table('users')->insert([
            'name' => "John Doe",
            'email' => 'john@gmail.com',
            'phone' => '9876543211',
            'street_address' => '1835  Poplar Lane',
            'city' => 'Ft Lauderdale',
            'state' => 'Florida',
            'zip' => '33311',
            'type' => "User",
            'password' => bcrypt('user@123'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('users')->insert([
            'name' => "Rahul Patil",
            'email' => 'rahul@gmail.com',
            'phone' => '9876543212',
            'street_address' => '412  School House Road',
            'city' => 'Meridian Naval Air s',
            'state' => 'Mississippi',
            'zip' => '39301',
            'type' => "User",
            'password' => bcrypt('user@123'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

    }
}
