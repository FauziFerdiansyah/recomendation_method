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
        $data_records = array(
          array(
            'name'		=> 'Admin',
            'email'		=> 'admin@admin.com',
            'password'	=> bcrypt('admin'),
            'status'	=> 2,
            'created_by'    => 1,
            'updated_by'    => 1,
            'created_at'	=> date('Y-m-d H:i:s'),
            'updated_at'	=> date('Y-m-d H:i:s')
          )
      );
      DB::table('users')->insert($data_records);
    }
}
