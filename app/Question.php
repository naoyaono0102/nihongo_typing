<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //クラス名「Question」の複数形「Questions」を操作対象のテーブルとして自動で判別してくれる。
    // テーブル名が複数形じゃない場合は protected $table = 'テーブル名'で宣言する

    //DBで間違っても変更させたないカラム（IDなど）にはロックをかけてかくことができる。
    //ロックのかけ方は以下の２種類

    //① モデルがその属性以外を持たなくなる（fillメソッドに対応しやすいが、カラムが増えるほど、足していく必要がある。）
    protected $fillable = ['question', 'answer'];

    //② モデルからその属性が取り除かれる（カラムが増えても追加する必要ないので、簡単）
    // protected $guarded = ['id']

}
