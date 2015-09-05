<!-- resoucees/views/base.blade.php -->

@extends('base')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/sexy-form/css/style.css') }}">
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('assets/sexy-form/js/jquery.uniform.min.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
        $(function(){
            $("input:checkbox, input:radio, input:file, select").uniform();
        });
    </script>
@foreach($errors->all() as $error)
    <li><span style="color: red">{{ $error }}</span></li>
@endforeach

{!! Form::open(['files' => true]) !!}
    <div class="post">
        <ul>
            <li>
                {!! Form::label('お名前') !!}
                <div>
                {!! Form::input('text', 'name', old('name'), ['class' => '']) !!}
                @if($errors->has('name'))
                        <div class="error">{{ $errors->first('name') }}</div>
                @endif
                </div>
            </li>
            <li>
                {!! Form::label('見た目') !!}
                {!! Form::select('sex', $sex, []) !!}
            </li>
            <li>
                {!! Form::label('年齢') !!}
                {!! Form::select('age', $age, []) !!}
            </li>
            <li style="height: 110px">
                {!! Form::label('興味') !!}<br>

                <label>
                    <div class="checker">
                    {!! Form::checkbox('joso', 1, false) !!}
                    </div>
                    女装
                </label>
                <label>
                    <div class="checker">
                        {!! Form::checkbox('mazo', 1, false) !!}
                    </div>
                    マゾ
                </label>
                <label>
                    <div class="checker">
                        {!! Form::checkbox('sado', 1, false) !!}
                    </div>
                    サド
                </label>
                <label>
                    <div class="checker">
                        {!! Form::checkbox('rosyutsu', 1, false) !!}
                    </div>
                    露出
                </label>
                <label>
                    <div class="checker">
                        {!! Form::checkbox('熟女', 1, false) !!}
                    </div>
                    熟女
                </label>
                <label>
                    <div class="checker">
                        {!! Form::checkbox('アナル', 1, false) !!}
                    </div>
                    アナル
                </label>
                <label>
                    <div class="checker">
                        {!! Form::checkbox('sm', 1, false) !!}
                    </div>
                    SM
                </label>
                <label>
                    <div class="checker">
                        {!! Form::checkbox('kosupure', 1, false) !!}
                    </div>
                    コスプレ
                </label>
                <label>
                    <div class="checker">
                        {!! Form::checkbox('rezu', 1, false) !!}
                    </div>
                    レズ
                </label>
                <label>
                    <div class="checker">
                        {!! Form::checkbox('gei', 1, false) !!}
                    </div>
                    ゲイ
                </label>
                <label>
                    <div class="checker">
                        {!! Form::checkbox('onani', 1, false) !!}
                    </div>
                    オナニー
                </label>
                <label>
                    <div class="checker">
                        {!! Form::checkbox('kinbaku', 1, false) !!}
                    </div>
                    緊縛
                </label>
            </li>
            <li>
                <div>
                {!! Form::label('タイトル') !!}
                {!! Form::input('text', 'title', $article ? 'Re: '.$article->title : old('title'), ['class' => '', 'style' => 'width: 350px']) !!}
                @if($errors->has('title'))
                    <div class="error">{{ $errors->first('title') }}</div>
                @endif
                </div>
            </li>
            <li>
                <div>
                {!! Form::label('本文') !!}
                {!! Form::textarea('body', old('body'), ['style' => 'width: 350px', 'rows' => 10, 'cols' => 40]) !!}
                @if($errors->has('body'))
                    <div class="error">{{ $errors->first('body') }}</div>
                @endif
                </div>
            </li>
            <li>
                {!! Form::label('添付画像１') !!}
                {!! Form::file('file1') !!}
            </li>
            <li>
                {!! Form::label('添付画像２') !!}
                {!! Form::file('file2') !!}
            </li>
            <li>
                {!! Form::label('パスワード') !!}
                {!! Form::input('password', 'password', old('password'), ['class' => 'form-control']) !!}
            </li>
            @if(isset($article))
            {!! Form::input('hidden', 'res_id', $article->id) !!}
            @endif
            <li>
            <button type="submit" class="write">書き込み</button>
            </li>
        </ul>
    </div>
{!! Form::close() !!}
@endsection