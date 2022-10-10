<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->integer('customer_id', 11)->unique()->autoIncrement();
            $table->string('customer_name', 255);
            $table->string('email', 255)->unique();
            $table->string('tel_num', 14);
            $table->string('address', 255);
            $table->boolean('is_active')->default(1)->nullable();
            $table->timestamps();

            $table->index(['customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
};
