<?php

use Illuminate\Database\Seeder;

class DescriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for($i = 0; $i < 5; $i++) {
	    	$now = date('Y-m-d H:i:s', strtotime('now'));
	    	DB::table('descriptions')->insert([
	    		'product_id' => 1,
	    		'body' => uniqid(),
	    		'created_at' => $now,
	    		'updated_at' => $now
	    	]);
	    }
    }
}
