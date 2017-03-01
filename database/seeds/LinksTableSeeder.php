<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{

    public function run()
    {
        $data = [
            [
                'link_name' => 'facebook',
                'link_description' => 'The dumbest kids from your high school all reproduced.',
                'link_url' => 'https://www.facebook.com',
                'link_order'=> 1,
            ],
            [
                'link_name' => 'twitter',
                'link_description' => 'Yours To Discover',
                'link_url' => 'https://www.twitter.com',
                'link_order'=> 2,
            ]
        ];
        DB::table('links')->insert($data);
    }
}
