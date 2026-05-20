<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortOrderToTagsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('tags', 'sort_order')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->integer('sort_order')->default(0)->after('status');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('tags', 'sort_order')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->dropColumn('sort_order');
            });
        }
    }
}
