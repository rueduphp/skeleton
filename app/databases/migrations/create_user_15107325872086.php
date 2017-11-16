<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
class CreateUser15107325872086
{
    public function up(Builder $schema)
    {
        $schema->create('user', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }
    
    public function down(Builder $schema)
    {
        $schema->dropIfExists('user');
    }
}