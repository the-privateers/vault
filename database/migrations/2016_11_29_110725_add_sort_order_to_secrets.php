<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSortOrderToSecrets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('secrets', function (Blueprint $table) {
            $table->integer('linked_lockbox_id')->unsigned()->default(0)->after('value');
            $table->integer('sort_order')->unsigned()->default(0)->after('paranoid');
        });

        $lockboxes = \Vault\Lockboxes\Lockbox::get();

        foreach($lockboxes as $lockbox)
        {
            foreach($lockbox->secrets as $index => $secret)
            {
                \Illuminate\Support\Facades\DB::table('secrets')->where('id', $secret->id)->update(['sort_order' => $index]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('secrets', function (Blueprint $table) {
            $table->dropColumn(['sort_order', 'linked_lockbox_id']);
        });
    }
}
