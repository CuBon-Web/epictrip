<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTourServicesToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'included_services')) {
                $table->longText('included_services')->nullable()->after('ingredient');
            }
            if (!Schema::hasColumn('products', 'excluded_services')) {
                $table->longText('excluded_services')->nullable()->after('included_services');
            }
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'excluded_services')) {
                $table->dropColumn('excluded_services');
            }
            if (Schema::hasColumn('products', 'included_services')) {
                $table->dropColumn('included_services');
            }
        });
    }
}
