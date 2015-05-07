<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVkidToUsersTable extends Migration {

    const VK_ID_COLUMN = 'vkid';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table) {
            $table->integer(self::VK_ID_COLUMN)->unsigned()->nullable()->index();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table) {
            $table->dropColumn(self::VK_ID_COLUMN);
        });
	}

}
