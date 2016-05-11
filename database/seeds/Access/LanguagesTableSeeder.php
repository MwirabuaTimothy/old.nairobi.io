<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder {
public function run() {
		DB::table('languages')->delete();

		DB::table('languages')->insert(array(
    array('language_code' => 'ar','language_name' => 'Arabic'),
    array('language_code' => 'bg','language_name' => 'Bulgarian'),
    array('language_code' => 'bs','language_name' => 'Bosnian'),
    array('language_code' => 'ca','language_name' => 'Catalan; Valencian'),
    array('language_code' => 'cy','language_name' => 'Welsh'),
    array('language_code' => 'da','language_name' => 'Danish'),
    array('language_code' => 'de','language_name' => 'German'),
    array('language_code' => 'el','language_name' => 'Greek'),
    array('language_code' => 'en','language_name' => 'English'),
    array('language_code' => 'es','language_name' => 'Spanish'),
    array('language_code' => 'et','language_name' => 'Estonian'),
    array('language_code' => 'fa','language_name' => 'Persian'),
    array('language_code' => 'fr','language_name' => 'French'),
    array('language_code' => 'ga','language_name' => 'Irish'),
    array('language_code' => 'he','language_name' => 'Hebrew'),
    array('language_code' => 'hi','language_name' => 'Hindi'),
    array('language_code' => 'ht','language_name' => 'Haitian'),
    array('language_code' => 'hu','language_name' => 'Hungarian'),
    array('language_code' => 'it','language_name' => 'Italian'),
    array('language_code' => 'ja','language_name' => 'Japanese (ja)'),
    array('language_code' => 'la','language_name' => 'Latin'),
    array('language_code' => 'pl','language_name' => 'Polish'),
    array('language_code' => 'pt','language_name' => 'Portuguese'),
    array('language_code' => 'ro','language_name' => 'Romanian'),
    array('language_code' => 'ru','language_name' => 'Russian'),
    array('language_code' => 'so','language_name' => 'Somali'),
    array('language_code' => 'su','language_name' => 'Sundanese'),
    array('language_code' => 'sv','language_name' => 'Swedish'),
    array('language_code' => 'sw','language_name' => 'Swahili',
    array('language_code' => 'uk','language_name' => 'Ukrainian'),
    array('language_code' => 'zh','language_name' => 'Chinese'),
    array('language_code' => 'zu','language_name' => 'Zulu'),
		));

	}
}