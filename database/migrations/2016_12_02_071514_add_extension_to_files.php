<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtensionToFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->string('extension')->nullable()->default(null)->after('file_type');
        });

        $files = \Vault\Files\File::get();

        foreach($files as $file)
        {
            $parts = explode('.', $file->original_name);

            \Illuminate\Support\Facades\DB::table('files')->where('id', $file->id)->update(['extension' => last($parts)]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn(['extension']);
        });
    }
}
