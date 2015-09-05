<!-- resoucees/views/base.blade.php -->

@extends('base')

@section('content')
    <div class="post-title">新規投稿</div>
    <div id="reply-article"></div>
    @include('parts/post', ['display' => 'block', 'article_id' => 0])

    @foreach($articles as $row)
        <article>
            {{-- メインの記事 --}}
            @include('parts/article_box', ['class' => 'article_box', 'isReply' => false])
            {{-- 返信の記事 --}}
            @foreach($row->selfJoin as $row)
                @include('parts/article_box', ['class' => 'article_box replay_box', 'isReply' => true])
            @endforeach
        </article>
    @endforeach

    {!! $articles->appends($conditions)->render() !!}
    {!! csrf_field() !!}

    <script src="{{ asset('assets/js/index.js') }}" defer="defer"></script>
@endsection

@section('inline-script')
    @parent
@endsection
