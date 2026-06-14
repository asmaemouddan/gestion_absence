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
    Schema::table('seances', function (Blueprint $table) {
        $table->string('photo')->nullable()->after('heure_fin');
    });
}

public function down(): void
{
    Schema::table('seances', function (Blueprint $table) {
        $table->dropColumn('photo');
    });
}
};
