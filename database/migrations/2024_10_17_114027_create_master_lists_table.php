<?php

use App\Models\CategoryMasterList;
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
        Schema::create('master_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('drawing_number')->nullable();
            $table->string('address_of_drawing');
            $table->string('name_of_machine');
            $table->text('drawing_file_contents')->nullable();
            $table->text('remarks')->nullable();
            $table->string('slug');
            $table->foreignIdFor(CategoryMasterList::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_lists');
    }
};
