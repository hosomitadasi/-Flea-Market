<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!---->

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!---->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!---->

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!---->

    <title>@yield('title')</title>

    <script src="https://kit.fontawesome.com/42694f25bf.js" crossorigin="anonymous"></script>
    <!-- Font Awesomeを利用するためのscript。本来なら作成したアカウントのscriptをコピーする。 以下詳細な説明をしているサイトがあったのでリンクを貼る。https://qiita.com/tkhslab/items/f9abe0424ebd9f73a00c -->

    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <!-- 郵便番号を入力すると自動で住所を入力してくれるようになるscript。 https://qiita.com/macer_fkm/items/2fbeceb0e1d93ad4a1f1 -->

    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <!-- 認証成功、失敗などのロゴを表示するレイアウトを簡単に作ってくれるscript。  -->
    @yield('css')
</head>

<body>
    @yield('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- 認証成功、失敗などのロゴを表示するレイアウトを簡単に作ってくれるscriptである<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">の機能の1つ。  -->

    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
        }

        @if(Session::has('flashSuccess'))
        toastr.success("{{ session('flashSuccess') }}");
        @endif
    </script>
</body>

</html>