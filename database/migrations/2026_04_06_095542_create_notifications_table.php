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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type'); // here we will store the class type, like: App\Notifications\NewCommentNotification
            $table->morphs('notifiable');// notifiable_type answers → "what kind of model receives this notification?" In your case it will always be App\Models\User because only users receive notifications. -------- notifiable_id answers → "which specific user?" This is just the user's ID, like 5 or 12.
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
