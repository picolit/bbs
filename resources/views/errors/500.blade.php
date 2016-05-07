<!-- resoucees/views/errors/500.php -->

@extends('base')

@section('content')
    <div class="post-title">システムエラーが発生しました</div>
    <div style="width: 100%; background-color: white">
        <br>
        システムエラーが発生しました。時間をおいて再度お試しください。
        <br>
	トップページでブラウザの更新してください。
        <br>
        <span>{!! link_to_route('articles.getIndex', 'トップへ戻る') !!}</span>
    </div>
@endsection

@section('inline-script')
    @parent
@endsection
