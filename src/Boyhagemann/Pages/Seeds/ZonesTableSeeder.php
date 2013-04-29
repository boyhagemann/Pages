<?php

namespace Boyhagemann\Pages\Seeds;
use Seeder, DB;

class ZonesTableSeeder extends Seeder {

    public function run()
    {
         DB::table('zones')->insert(array(
             'title' => 'Content',
             'name' => 'content',
             'layout_id' => 1,
         ));
         DB::table('zones')->insert(array(
             'title' => 'Sidebar',
             'name' => 'sidebar',
             'layout_id' => 1,
         ));
    }

}