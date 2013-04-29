<?php

namespace Boyhagemann\Pages\Seeds;

use Seeder,
    Eloquent;

class DatabaseSeeder extends Seeder 
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() 
    {
        Eloquent::unguard();

        $this->call('Boyhagemann\Pages\Seeds\LayoutsTableSeeder');
        $this->call('Boyhagemann\Pages\Seeds\ZonesTableSeeder');
    }

}