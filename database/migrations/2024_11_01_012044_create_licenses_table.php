<?php

use App\Enums\Access;
use App\Enums\Section;
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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
                        
            $table->unsignedBigInteger("role_id");
            $table->foreign("role_id")->references("id")->on("roles")->onDelete("cascade");
    
            $table->enum("access",array_column(Access::cases(),"value"));
    
            $table->enum("section",array_column(Section::cases(),"value"));

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
