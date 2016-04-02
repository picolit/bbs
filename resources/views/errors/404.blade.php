<!-- resoucees/views/errors/404.blade.php -->

@extends('base')

@section('content')
    <div class="post-title">ページが見つかりません</div>
    <div style="width: 100%; background-color: white">
        <br>
        <span >{!! link_to_route('articles.getIndex', 'トップへ戻る') !!}</span>
    </div>
@endsection

@section('inline-script')
    @parent
@endsection
