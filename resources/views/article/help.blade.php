<!-- resoucees/views/base.blade.php -->

@extends('base')

@section('content')
<div class="common-content">
    <div class="title">
        ヘルプ
    </div>
    <div class="help-box">
        <h4 style="color: red; font-weight: bold">禁止事項</h4>
        <ul>
            <li>・未成年を募集する内容の書き込み</li>
            <li>・援助交際に関する書き込み</li>
            <li>・性器描写のある画像投稿</li>
            <li>・誹謗中傷の書き込み</li>
            <li>・その他管理人が不適切だと判断した書き込み</li>
        </ul>

        <h4>通知用メールアドレスとは?</h4>
        <span>
            通知用メールアドレス欄にメールアドレスを記入するとBBSに新規レスがあった場合に通知メールが送られて来ます。<br>
            わざわざ掲示板にアクセスしてレスがついたかどうかを確認する必要がなく、非常に便利な機能ですので是非ご利用ください。<br>
            お相手と直接やりとりする機能ではございませんのでご注意ください<br>
            注)メールは当掲示板から送信されるのでドメイン指定をしている場合には&nbsp;peach-x.pw&nbsp;のドメインを解除してください<br>
        </span>

        <h4>Twitter投稿とは？</h4>
        <span>
            投稿された内容はtwitterへ自動でツイートされます。(名前、タイトル、本文の一部)<br>
            「Peach-X」をフォローして頂ければ、投稿内容を知ることができます。<br>
            個人を特定する内容がツイートされることはありません。
        </span>

        <h4>画像を貼る</h4>
        <span>
            書き込みをすると追加機能として画像を載せることができます。<br>
            無修正局部や画像などの掲載は削除します。
        </span>
        <h4>お問い合わせ</h4>
        <span>
            <a href="{!! route('articles.getInquiry') !!}">こちら</a>
        </span>
        <div class="back-box">
            <a class="btn link-btn" href="{!! route('articles.getIndex') !!}">戻る</a>
        </div>
    </div>
</div>
@endsection

@section('inline-script')
    @parent
@endsection
