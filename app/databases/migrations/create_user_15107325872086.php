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
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();

            $table->engine = 'InnoDB';
        });

        $schema->create('role', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->string('slug');
            $table->string('name');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->unique('slug');

            $table->engine = 'InnoDB';
        });

        $schema->create('role_user', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->index('user_id');
            $table->index('role_id');

            $table->engine = 'InnoDB';
        });
    }

    public function down(Builder $schema)
    {
        $schema->dropIfExists('user');
        $schema->dropIfExists('role');
        $schema->dropIfExists('role_user');
    }
}
