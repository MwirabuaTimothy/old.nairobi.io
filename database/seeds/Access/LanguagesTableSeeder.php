<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class LanguagesTableSeeder
 */
class LanguagesTableSeeder extends Seeder {
    public function run() {
		DB::table('languages')->delete();

		DB::table('languages')->insert([
            ['language_code' => 'ar','language_name' => 'Arabic'],
            ['language_code' => 'bg','language_name' => 'Bulgarian'],
            ['language_code' => 'bs','language_name' => 'Bosnian'],
            ['language_code' => 'ca','language_name' => 'Catalan; Valencian'],
            ['language_code' => 'cy','language_name' => 'Welsh'],
            ['language_code' => 'da','language_name' => 'Danish'],
            ['language_code' => 'de','language_name' => 'German'],
            ['language_code' => 'el','language_name' => 'Greek'],
            ['language_code' => 'en','language_name' => 'English'],
            ['language_code' => 'es','language_name' => 'Spanish'],
            ['language_code' => 'et','language_name' => 'Estonian'],
            ['language_code' => 'fa','language_name' => 'Persian'],
            ['language_code' => 'fr','language_name' => 'French'],
            ['language_code' => 'ga','language_name' => 'Irish'],
            ['language_code' => 'he','language_name' => 'Hebrew'],
            ['language_code' => 'hi','language_name' => 'Hindi'],
            ['language_code' => 'ht','language_name' => 'Haitian'],
            ['language_code' => 'hu','language_name' => 'Hungarian'],
            ['language_code' => 'it','language_name' => 'Italian'],
            ['language_code' => 'ja','language_name' => 'Japanese (ja)'],
            ['language_code' => 'la','language_name' => 'Latin'],
            ['language_code' => 'pl','language_name' => 'Polish'],
            ['language_code' => 'pt','language_name' => 'Portuguese'],
            ['language_code' => 'ro','language_name' => 'Romanian'],
            ['language_code' => 'ru','language_name' => 'Russian'],
            ['language_code' => 'so','language_name' => 'Somali'],
            ['language_code' => 'su','language_name' => 'Sundanese'],
            ['language_code' => 'sv','language_name' => 'Swedish'],
            ['language_code' => 'sw','language_name' => 'Swahili'],
            ['language_code' => 'uk','language_name' => 'Ukrainian'],
            ['language_code' => 'zh','language_name' => 'Chinese'],
            ['language_code' => 'zu','language_name' => 'Zulu'],
		]);

	}
}