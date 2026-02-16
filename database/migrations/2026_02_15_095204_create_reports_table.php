<?php

use App\Models\User;
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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete(); // this is the reporter and you should be able to access the bad guy from the morphs
            $table->enum('status', ['pending', 'resolved'])->default('pending'); // the status can be changed base on the next task
            $table->morphs('reportable'); // now this should include both the reportable_type (Type (class name) like App\Models\Post or App\Models\comment) and also reportable_id (ID of Post/Comment) shouldddddd!!
            $table->enum('category', ['spam','offensive','harassment','misinformation','violence','other']);
            $table->text('reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};



// $thing = $report->reportable;
// ```

// **Behind the scenes, Laravel does this:**

// 1. Looks at `reportable_type` → "App\Models\Post"
// 2. Looks at `reportable_id` → 25
// 3. **Automatically runs:** `Post::find(25)`
// 4. Returns the Post object