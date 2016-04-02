<div class="header">
    <div class="left">
        {!! Form::text('search_word', null, ['placeholder' => 'エッチな言葉を検索']) !!}
        @if(isset($isActiveQueueListen) and (!$isActiveQueueListen))
            <span class="error">現在、返信通知メール、直接メールの機能が停止しています。</span>
        @endif
    </div>
    <div class="center">
        <p>Peach-X</p>
    </div>
    <div class="right">
        <a href="{!! route('articles.getHelp') !!}">ヘルプ</a>
    </div>
</div>