<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('email', 100);
            $table->char('token_hash', 64)->unique();
            $table->integer('invited_by');
            $table->timestamp('expires_at');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
            $table->index(['team_id', 'email', 'accepted_at']);
            $table->foreign('invited_by')
                ->references('id_pengguna')
                ->on('pengguna')
                ->cascadeOnDelete();
        });

        Schema::create('team_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->integer('user_id');
            $table->text('message');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id_pengguna')
                ->on('pengguna')
                ->cascadeOnDelete();
            $table->index(['team_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_messages');
        Schema::dropIfExists('team_invitations');
    }
};