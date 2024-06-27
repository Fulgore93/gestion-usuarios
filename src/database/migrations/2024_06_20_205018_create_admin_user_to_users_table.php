<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        User::create(['id' => 1, 'name' => 'Admin user', 'email' => 'test@test.com', 'password' => Hash::make('password'), 'is_admin' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::destroy([1]);
        DB::statement("ALTER TABLE users AUTO_INCREMENT = 1;");
    }
};
