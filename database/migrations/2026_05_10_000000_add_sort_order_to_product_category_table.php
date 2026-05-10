<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortOrderToProductCategoryTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('product_category', 'sort_order')) {
            Schema::table('product_category', function (Blueprint $table) {
                $table->integer('sort_order')->default(0)->after('status');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('product_category', 'sort_order')) {
            Schema::table('product_category', function (Blueprint $table) {
                $table->dropColumn('sort_order');
            });
        }
    }
}
