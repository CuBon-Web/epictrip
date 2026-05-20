<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortOrderToTagCateTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('tag_cate', 'sort_order')) {
            Schema::table('tag_cate', function (Blueprint $table) {
                $table->integer('sort_order')->default(0)->after('status_filter');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('tag_cate', 'sort_order')) {
            Schema::table('tag_cate', function (Blueprint $table) {
                $table->dropColumn('sort_order');
            });
        }
    }
}
