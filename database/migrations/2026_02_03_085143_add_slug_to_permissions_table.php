<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        // 1. Add slug column (nullable first)
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });

        // 2. Fill slug for existing permissions
        DB::table('permissions')->get()->each(function ($permission) {
            DB::table('permissions')
                ->where('id', $permission->id)
                ->update([
                    'slug' => Str::slug($permission->name)
                ]);
        });

        // 3. Make slug unique
        Schema::table('permissions', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
