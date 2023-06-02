<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('products')->where('company_id', '2')->update(['company_id' => '3']);
        DB::table('products')->where('company_id', '4')->update(['company_id' => '3']);
        DB::table('products')->where('company_id', '5')->update(['company_id' => '2']);
        DB::table('products')->where('company_id', '6')->update(['company_id' => '1']);
        DB::table('products')->where('company_id', '7')->update(['company_id' => '3']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('prodcuts')->where('company_id', '3')->update(['company_id' => '2']);
        DB::table('products')->where('company_id', '3')->update(['company_id' => '4']);
        DB::table('products')->where('company_id', '2')->update(['company_id' => '5']);
        DB::table('products')->where('company_id', '1')->update(['company_id' => '6']);
        DB::table('products')->where('company_id', '3')->update(['company_id' => '7']);
    }
};
