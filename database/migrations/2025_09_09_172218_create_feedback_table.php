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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('region_id');
            $table->enum('gender', ['ME', 'MKE']);
            $table->enum('membership', [
                'Mwajiriwa', 'Hiari', 'Mstaafu', 'Mtegemezi', 'Sio Mwanachama'
            ]);
            $table->enum('visit_reason', [
                'Mafao', 'Usajili', 'Michango', 'Nyaraka'
            ]);
            $table->enum('waiting_time', ['0-10', '10-20', '20-30', '30-60']);
            $table->enum('satisfaction_time', [
                'Nimeridhika sana', 'Nimeridhika', 'Sina uhakika', 'Sijaridhika', 'Sijaridhika kabisa'
            ]);
            $table->enum('needs_met', [
                'Zinakidhi sana', 'Zinakidhi', 'Sina hakika', 'Hazikidhi', 'Hazikidhi kabisa'
            ]);
            $table->enum('service_quality', [
                'Zimeboreshwa sana', 'Zimeboreshwa', 'Za wastani', 'Zimedoro'
            ]);
            $table->enum('problem_handling', [
                'Kwa haraka sana', 'Kwa haraka', 'Sina hakika', 'Taratibu', 'Taratibu sana'
            ]);
            $table->enum('staff_responsiveness', [
                'Wanawajibika sana', 'Wanawajibika', 'Kwa wastani', 'Hawawajibiki', 'Hawawajibiki kabisa'
            ]);
            $table->enum('overall_satisfaction', [
                'Ninaridhika sana', 'Ninaridhika', 'Sina uhakika', 'Siridhiki'
            ]);
            $table->text('suggestions')->nullable();
            $table->timestamps();

            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
