<?php

namespace Boyhagemann\Pages\Seeds;
use Seeder, DB;

class LayoutsTableSeeder extends Seeder {

    public function run()
    {        
         DB::table('layouts')->insert(array(
             'title' => 'Default layout',
             'name' => 'pages::layouts.cms',
         ));
    }

}