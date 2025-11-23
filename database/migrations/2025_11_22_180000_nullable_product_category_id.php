<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('products', 'category_id')) {
            return;
        }

        DB::statement('ALTER TABLE products MODIFY category_id BIGINT UNSIGNED NULL DEFAULT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('products', 'category_id')) {
            return;
        }

        DB::statement('ALTER TABLE products MODIFY category_id BIGINT UNSIGNED NOT NULL');
    }
};
