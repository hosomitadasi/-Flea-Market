<?php

use Illuminate\Database\Migrations\Migration;
/* マイグレーション全体のベースクラス */
use Illuminate\Database\Schema\Blueprint;
/* テーブル全体の構造定義に使用 */
use Illuminate\Support\Facades\Schema;
/* テーブルの作成や削除などといったスキーマの操作全般を定義 */

class CreateProfilesTable extends Migration
{

    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            /* Profilesテーブルを作成。ueprint $table：テーブルの列構造を定義するための引数 */
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->unique();
            /* user_idカラムを作成。constrained()は他のテーブルであるusersテーブルのidを参照する外部キー制約を追加。cascadeOnDelete()はユーザーが削除された際に紐づくプロフィールも自動的に削除するようにするという制約を付ける。unique()は１ユーザーは１Profileしか持てないように制約すること。 */
            $table->string('img_url')->nullable();
            $table->string('postcode');
            $table->string('address');
            $table->string('building')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
