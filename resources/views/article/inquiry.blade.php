<!-- resoucees/views/base.blade.php -->

@extends('base')

@section('content')
<div class="common-content">
    <div class="title">
        お問い合わせ
    </div>
    <div class="help-box">
    <p>■免責事項<br>
        公開されている画像・動画は、各関連企業や団体とは一切関係有りません。<br>
        使用している版権物の知的所有権は、それぞれの著作者・団体に帰属しています。<br>
        著作権所有者様からの警告及び修正、撤去のご連絡があった場合は、
        迅速に対処または削除をおこないます。<br>
        また、掲載内容に関しては、万全を期しておりますが、その内容を保証する事は出来ません。<br>
        当サイトを利用したことによる間接、直接の損害、その他いかなる損害に関して一切当サイトは、
        責任を負いません。<br>
        当サイトをご利用される場合は、以上のことをご理解、ご承諾されたものとさせて頂きます。<br>
        また、当サイトの掲載情報に法的問題が生じる場合や画像などの著作権所有者様からの削除依頼は、
        該当記事コメント欄よりご連絡下さい。<br>
        ただちに対処いたします。
    </p>

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
                        {!! Form::submit('送信', ['class' => 'btn link-btn', 'style' => 'margin-right: 10px']) !!}
                    </li>
                    <li>
                        <a class="btn link-btn" href="{!! route('articles.getIndex') !!}">戻る</a>
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
            alert("お問い合わせを受け付けました。");
        }
    });
@endsection
