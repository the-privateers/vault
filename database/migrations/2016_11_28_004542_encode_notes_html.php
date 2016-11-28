<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EncodeNotesHtml extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $lockboxes = \Vault\Lockboxes\Lockbox::whereNotNull('notes')->get();

        foreach($lockboxes as $lockbox)
        {
            $lockbox->notes = parse_markdown($lockbox->notes);

            $lockbox->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
