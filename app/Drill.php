<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drill extends Model
{

    //クラス名「Drill」の複数形「Drills」を操作対象のテーブルとして自動で判別してくれる。
    // テーブル名が複数形じゃない場合は protected $table = 'テーブル名'で宣言する

    //DBで間違っても変更させたないカラム（IDなど）にはロックをかけてかくことができる。
    //ロックのかけ方は以下の２種類

    //① 変更したいカラムを書いていく
    //モデルがその属性以外を持たなくなる（fillメソッドに対応しやすいが、カラムが増えるほど、足していく必要がある。）
    protected $fillable = ['title','category_id', 'published_flg'];

    //② 変更したくないカラムを書く 
    // モデルからその属性が取り除かれる（カラムが増えても追加する必要ないので、簡単）
    // protected $guarded = ['id']

    //リレーションの設定 
     public function user()
     {
         return $this->belongsTo('App\User', 'create_user');  //第二引数は外部キー（紐付けたいキー）
     }
    
}
