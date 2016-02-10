<?php

//use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialFieldsToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('email')->nullable()->change();
            $table->dropIndex('users_email_unique');
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('photo')->nullable();
            $table->unique(['email', 'provider', 'provider_id']);
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
            $table->dropColumn(['provider', 'provider_id', 'photo']);
            $table->string('email')->unique()->change();
        });
    }
}
