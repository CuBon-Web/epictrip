<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHighlightsToProductsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('products', 'highlights')) {
            Schema::table('products', function (Blueprint $table) {
                $table->longText('highlights')->nullable()->after('description');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('products', 'highlights')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('highlights');
            });
        }
    }
}
