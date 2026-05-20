<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddDurationDaysToProductsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('products', 'duration_days')) {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedInteger('duration_days')->default(0)->after('hang_muc');
            });
        }

        if (Schema::hasColumn('products', 'duration_days') && Schema::hasColumn('products', 'hang_muc')) {
            DB::table('products')
                ->whereNotNull('hang_muc')
                ->where('hang_muc', '!=', '')
                ->where('duration_days', 0)
                ->orderBy('id')
                ->chunkById(200, function ($rows) {
                    foreach ($rows as $row) {
                        if (preg_match('/(\d+)/', (string) $row->hang_muc, $matches)) {
                            DB::table('products')
                                ->where('id', $row->id)
                                ->update(['duration_days' => (int) $matches[1]]);
                        }
                    }
                });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('products', 'duration_days')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('duration_days');
            });
        }
    }
}
