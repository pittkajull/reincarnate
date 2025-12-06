<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('address')->nullable()->after('qty');
            $table->string('shipping_method')->default('regular')->after('address');
            $table->string('payment_method')->default('cod')->after('shipping_method');
            $table->string('note')->nullable()->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['address', 'shipping_method', 'payment_method', 'note']);
        });
    }
};
