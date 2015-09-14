<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1260, initial-scale=1.0", user-scalable=yes">
    <meta name="description" content="アダルト地域別コミュニケーションサイト">
    <meta name="keywords" content="{{ implode(', ', $keyword) }}">
    <meta name="author" content="peach-x">
    <meta http-equiv="content-language" content="ja">

    <title>変態仲間募集掲示板 | 地域別SNS　ピーチX</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

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
            <li><div class="left-content">@include('parts/left_content')</div></li>
            <li><div class="center-content">@yield ('content')</div></li>
            <li><div class="right-content">@include('parts/right_content')</div></li>
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
