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
        Schema::create('backup_logs', function (Blueprint $table) {
            $table->id();
            $table->char('name')->comment('备份名称');
            $table->char('type')->default('auto')->comment('备份类型');
            $table->integer('user_id')->default(0)->comment('操作者人id');
            $table->tinyInteger('status')->default(1)->comment('备份状态,1成功2失败');
            $table->integer('file_size')->comment('大小(单位字节)');
            $table->string('file_path')->comment('文件路径');
            $table->integer('used')->default(0)->comment('用时（秒）');
            $table->text('reason')->nullable()->comment('失败原因');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_logs');
    }
};
