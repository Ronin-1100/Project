<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('refunds', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['promotion_id']);

            $table->dropColumn(['product_id', 'promotion_id']);

            $table->unsignedBigInteger('trade_id')->nullable()->after('id');
            $table->string('reason')->nullable()->after('trade_id');

            $table->foreign('trade_id')
                ->references('id')
                ->on('trades')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('refunds', function (Blueprint $table) {
            $table->dropForeign(['trade_id']);
            $table->dropColumn(['trade_id', 'reason']);

            $table->unsignedBigInteger('product_id')->nullable()->after('id');
            $table->unsignedBigInteger('promotion_id')->nullable();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('promotion_id')
                ->references('id')
                ->on('promotions')
                ->nullOnDelete();
        });
    }
};

