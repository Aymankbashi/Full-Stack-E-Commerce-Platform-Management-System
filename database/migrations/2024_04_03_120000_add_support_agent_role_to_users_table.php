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
        // لا حاجة لتعديل الجدول لأن حقل role موجود بالفعل
        // سنقوم بتحديث البيانات الموجودة بدلاً من ذلك
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // لا حاجة للتراجع لأننا لم نعدل هيكل الجدول
    }
};
