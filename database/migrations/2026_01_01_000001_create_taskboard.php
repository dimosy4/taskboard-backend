<?php
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;
return new class {
    public function up(): void {
        $s = DB::schema();
        $s->create('users', function(Blueprint $t) {
            $t->increments('user_id'); $t->string('email')->unique();
            $t->string('password_hash'); $t->string('name');
            $t->timestamp('created_datetime')->useCurrent(); $t->timestamp('updated_datetime')->nullable();
        });
        $s->create('boards', function(Blueprint $t) {
            $t->increments('board_id'); $t->string('title');
            $t->unsignedInteger('owner_user_id'); $t->foreign('owner_user_id')->references('user_id')->on('users')->cascadeOnDelete();
            $t->boolean('is_public')->default(false);
            $t->timestamp('created_datetime')->useCurrent(); $t->timestamp('updated_datetime')->nullable();
        });
        $s->create('board_columns', function(Blueprint $t) {
            $t->increments('column_id'); $t->unsignedInteger('board_id');
            $t->foreign('board_id')->references('board_id')->on('boards')->cascadeOnDelete();
            $t->smallInteger('ordinal_position'); $t->string('title'); $t->string('color',6)->nullable();
            $t->index('board_id');
        });
        $s->create('cards', function(Blueprint $t) {
            $t->increments('card_id'); $t->unsignedInteger('board_id'); $t->unsignedInteger('column_id');
            $t->foreign('board_id')->references('board_id')->on('boards')->cascadeOnDelete();
            $t->foreign('column_id')->references('column_id')->on('board_columns')->cascadeOnDelete();
            $t->smallInteger('sort_index'); $t->string('title'); $t->text('content')->nullable();
            $t->string('color',6)->nullable(); $t->boolean('is_archived')->default(false);
            $t->timestamp('created_datetime')->useCurrent(); $t->timestamp('updated_datetime')->nullable();
        });
        DB::statement('CREATE INDEX idx_active_board_id ON cards (board_id) WHERE is_archived = false');
    }
    public function down(): void {
        $s = DB::schema(); foreach (['cards','board_columns','boards','users'] as $table) $s->dropIfExists($table);
    }
};
