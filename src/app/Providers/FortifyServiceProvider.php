<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
/* ユーザー登録時に使うカスタムアクション。CreateNewUser（app/Actions/Fortify内にある）を読み込む。 */

use App\Actions\Fortify\ResetUserPassword;
/* パスワード再設定時のアクションを読み込む。Fortifyではこれを登録しないとリセットできない。 */

use App\Actions\Fortify\UpdateUserPassword;
/* ユーザーが自分のパスワードを変更する時に使うアクション。*/

use App\Actions\Fortify\UpdateUserProfileInformation;
/* Profile情報（名前・メールアドレスなど）を更新する時に使用するアクション。 */

use App\Http\Requests\LoginRequest;
/* 独自に定義したログインバリデーションルールのFormRequest（LoginRequest）を使用。Fortifyデフォルトのものを上書きする。 */

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
/* ログイン試行回数を制限するために使用されるRateLimiterを定義するために必要なクラス群。 */

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                return redirect('/mypage/profile');
            }
        });
    }
    /* 会員登録後にどこへリダイレクトするか定義している。登録後にRegisterResponseのtoResponse()メソッドが呼ばれ、/mypage/profileへとリダイレクトする。 */

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        /* 会員登録フォームがPOSTされた時に、ユーザーを登録するロジックをどのクラスで実行するかを指定する。CreateNewUser クラスの __invoke() が呼ばれ、バリデーションやUserモデルの保存が行われる。それが実行されるのが/registerをPOSTする時。 */

        Fortify::registerView(function () {
            return view('auth.register');
        });
        /* /registerにGETでアクセスした時に表示するviewを指定。この場合はresources/views/auth/register.blade.php を表示するという指示になる。 */

        Fortify::loginView(function () {
            return view('auth.login');
        });
        /* /loginにGETでアクセスした時に表示するviewを指定。この場合はresources/views/auth/login.blade.php を表示するという指示になる。 */

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });
        /* ログイン試行の回数制限を定義。同じメールアドレスとIPの組み合わせで、１分あたり10回までに制限するものになっている。超えると「Too Many Attempts」エラーを返す。 */

        //デフォルトのログイン機能にあるフォームリクエストを自作のものに代替するため、サービスコンテナにバインド
        app()->bind(FortifyLoginRequest::class, LoginRequest::class);
    }
}
