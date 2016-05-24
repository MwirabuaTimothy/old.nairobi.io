<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagsTableSeeder extends Seeder 
{
	public function run()
	{		
		$list = [
			'Events',
			'Food',
			'Dining',
			'Arts', 
			'Culture',
			'Photography',
			'Movies',
			'Theatre',
			'Lifestyle', 
			'Design',
			'Travel', 
			'Leisure',
			'Technology',
			'Sports',
			'Weather',
			'Traffic',
			'Finance',
			'Politics'
        ];

		foreach($list as $tag)
		{
			Tag::create(array('name' => $tag));
		}
	}

}