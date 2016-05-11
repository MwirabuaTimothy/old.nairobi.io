<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class LanguagesTableSeeder
 */
class LanguagesTableSeeder extends Seeder {

	public function run() {
		DB::table('languages')->delete();

		DB::table('languages')->insert([
			['code' => 'ar', 'name' => 'Arabic'],
			['code' => 'bg', 'name' => 'Bulgarian'],
			['code' => 'bs', 'name' => 'Bosnian'],
			['code' => 'ca', 'name' => 'Catalan; Valencian'],
			['code' => 'cy', 'name' => 'Welsh'],
			['code' => 'da', 'name' => 'Danish'],
			['code' => 'de', 'name' => 'German'],
			['code' => 'el', 'name' => 'Greek'],
			['code' => 'en', 'name' => 'English'],
			['code' => 'es', 'name' => 'Spanish'],
			['code' => 'et', 'name' => 'Estonian'],
			['code' => 'fa', 'name' => 'Persian'],
			['code' => 'fr', 'name' => 'French'],
			['code' => 'ga', 'name' => 'Irish'],
			['code' => 'he', 'name' => 'Hebrew'],
			['code' => 'hi', 'name' => 'Hindi'],
			['code' => 'ht', 'name' => 'Haitian'],
			['code' => 'hu', 'name' => 'Hungarian'],
			['code' => 'it', 'name' => 'Italian'],
			['code' => 'ja', 'name' => 'Japanese (ja)'],
			['code' => 'la', 'name' => 'Latin'],
			['code' => 'pl', 'name' => 'Polish'],
			['code' => 'pt', 'name' => 'Portuguese'],
			['code' => 'ro', 'name' => 'Romanian'],
			['code' => 'ru', 'name' => 'Russian'],
			['code' => 'so', 'name' => 'Somali'],
			['code' => 'su', 'name' => 'Sundanese'],
			['code' => 'sv', 'name' => 'Swedish'],
			['code' => 'sw', 'name' => 'Swahili'],
			['code' => 'uk', 'name' => 'Ukrainian'],
			['code' => 'zh', 'name' => 'Chinese'],
			['code' => 'zu', 'name' => 'Zulu'],
		]);

	}
}