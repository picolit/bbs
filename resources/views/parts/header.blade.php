<div class="header">
    <div class="left">
        {!! Form::text('search_word', null, ['placeholder' => 'エッチな言葉を検索']) !!}
    </div>
    <div class="center">
        <p>Peach-X</p>
    </div>
    <div class="right">
        <a href="{!! route('articles.getHelp') !!}">ヘルプ</a>
    </div>
</div>