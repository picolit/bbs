<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1280px, initial-scale=1.0", user-scalable=yes">
    <meta name="description" content="アダルト地域別コミュニケーションサイト">
    <meta name="keywords" content="{{ implode(', ', $keyword) }}">
    <meta name="author" content="peach-x">
    <meta http-equiv="content-language" content="ja">

    <title>変態仲間募集掲示板 | 地域別SNS　ピーチX</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    @if(env('PROTOCOL') === 'http')
        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    @else
        <link rel="stylesheet" href="{{ secure_asset('assets/css/app.css') }}">
    @endif

    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>--}}
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <style>
{{-- 解説: インラインのCSSブロックです。各ページで追記ができます。--}}
@section ('inline-style')
    /*footer {*/
        /*margin-bottom: 5em;*/
    /*}*/
@show
{{-- 解説: セクションをこの場所に展開させたい場合、@showを指定します。--}}
    </style>

    {{--<script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>--}}
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-66094084-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>

<body>

{{-- 解説: 'app/views/partials/footer.blade.php' の内容をこの箇所に展開します。 --}}
{{--@include ('partials.footer') --}}
{{-- left content --}}
@include('parts/header')
<div class="main">
    <div>
        <ul class="nav">
            <li style="width: 300px"><div class="left-content">@include('parts/left_content')</div></li>
            <li style="width: 600px"><div class="center-content">@yield ('content')</div></li>
            <li style="width: 300px"><div class="right-content">@include('parts/right_content')</div></li>
        </ul>
    </div>
</div>
@include('parts/footer')
    <script>
{{-- 解説: インラインのJavaScriptブロックです。各ページで追記ができます。--}}
@section ('inline-script')
@show
{{-- 解説: セクションをこの場所に展開させたい場合、@showを指定します。--}}
    </script>
</body>
</html>
