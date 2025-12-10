<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_uploads', function (Blueprint $table) {
            $table->id();
            
            // Siapa yang upload? (Optional, nullable jika guest boleh upload)
            $table->foreignId('uploaded_by')->nullable()->constrained('employees')->nullOnDelete(); 
            
            $table->string('filename');         // Nama asli file
            $table->string('disk');             // public, s3, dll
            $table->string('path');             // uploads/media/gambar.jpg
            $table->string('mime_type');        // image/jpeg
            $table->unsignedBigInteger('size'); // Ukuran dalam bytes
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_uploads');
    }
};