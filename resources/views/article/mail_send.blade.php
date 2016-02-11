@extends('base')

@section('content')
    <div class="common-content">
        <div class="title">
            {{ $article->name }} さんへメールで連絡
        </div>
        <div class="help-box">
            <p>直接メールで連絡できます。</p>

            <div>
                {!! Form::open(['class' => 'my-form', 'files' => false]) !!}
                {!! Form::hidden('complete_flg', isset($flg) ? 1: 0, ['id' => 'complete_flg']) !!}
                <p>お名前 (必須）<br>
                    {!! Form::text('name') !!}
                    @if($errors->has('name')) {!! $errors->first('name', '<p class="error">:message</p>') !!} @endif
                </p>
                <p>メールアドレス (必須）<br>
                    {!! Form::email('email', null, ['style' => 'width: 200px']) !!}
                    @if($errors->has('email')) {!! $errors->first('email', '<p class="error">:message</p>') !!} @endif
                </p>
                <p>題名 (必須）<br>
                    {!! Form::text('title', null, ['style' => 'width: 200px']) !!}
                    @if($errors->has('title')) {!! $errors->first('title', '<p class="error">:message</p>') !!} @endif
                </p>
                <p>メッセージ本文 (必須）<br>
                    {!! Form::textarea('body', null, ['cols' => 70]) !!}
                    @if($errors->has('body')) {!! $errors->first('body', '<p class="error">:message</p>') !!} @endif
                </p>
                <p>

                </p>
                <ui>
                    <li>
                        <a class="btn link-btn" style="margin-right: 10px" href="{!! route('articles.getIndex') !!}">戻る</a>
                    </li>
                    <li>
                        {!! Form::submit('送信', ['class' => 'btn link-btn']) !!}
                    </li>
                </ui>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('inline-script')
    @parent
    $(document).ready(function(){
        if ($("#complete_flg").val() === "1") {
            alert("メールを送信しました。");
        }
    });
@endsection