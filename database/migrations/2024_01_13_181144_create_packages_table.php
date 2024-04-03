<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('sender_code');
            $table->string('receiver_code');
            $table->foreignId('sender_branch_id');
            $table->foreignId('receiver_branch_id');
            $table->decimal('weight', 10, 2);
            $table->decimal('height', 10, 2);
            $table->decimal('width', 10, 2);
            $table->decimal('length', 10, 2);
            $table->boolean('fragile')->nullable();
            $table->boolean('fast_shipping')->nullable();
            $table->string('shipping_method')->nullable();
            $table->boolean('insurance')->default(false);
            $table->boolean('is_refrigerated')->default(false);
            $table->text('description')->nullable();
            $table->text('signature')->nullable();
            $table->foreignId('transit_branch_id')->nullable();
            $table->enum('status', \App\Enums\ShippingStatus::array())->default('Pending');
            $table->string('payment_method')->nullable();
            //rating
            $table->integer('rating')->default(0);

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
