<div class="post-form" style="display: {{ $display }}" id="{{$article_id}}">
    {{--<div class="post-title">新規投稿</div>--}}
    {!! Form::open(['id' => 'myForm', 'class' => 'my-form', 'files' => true]) !!}

        {!! Form::hidden('parent_id', 0) !!}

        <div style="margin-bottom: 5px">
            @if($errors->has('name'))
                <span class="require">*</span>{!! Form::text('name', null, ['class' => 'error', 'placeholder' => 'お名前（必須）']) !!}
            @else
                <span class="require">*</span>{!! Form::text('name', null, ['class' => '', 'placeholder' => 'お名前（必須）']) !!}
            @endif
            @if($errors->has('title'))
                <span class="require">*</span>{!! Form::text('title', null, ['class' => 'error', 'placeholder' => 'タイトル（必須）', 'style' => 'width:200px']) !!}
            @else
                <span class="require">*</span>{!! Form::text('title', null, ['class' => '', 'placeholder' => 'タイトル（必須）', 'style' => 'width:200px']) !!}
            @endif
            {!! Form::text('password', null, ['class' => '', 'placeholder' => 'パスワード', 'style' => 'width:150px']) !!}
        </div>
        <div>
            @if($errors->has('sex'))
                <span class="require">*</span>{!! Form::select('sex', $sexList, null, ['class' => 'error']) !!}
            @else
                <span class="require">*</span>{!! Form::select('sex', $sexList) !!}
            @endif
            @if($errors->has('age'))
                <span class="require">*</span>{!! Form::select('age', $ageList, null, ['class' => 'error']) !!}
            @else
                <span class="require">*</span>{!! Form::select('age', $ageList) !!}
            @endif
            @if($errors->has('prefectures'))
                <span class="require">*</span>{!! Form::select('prefectures', $prefecturesList, null, ['class' => 'error']) !!}
            @else
                <span class="require">*</span>{!! Form::select('prefectures', $prefecturesList) !!}
            @endif
            {!! Form::email('mail', null, ['placeholder' => 'メールアドレス', 'style' => 'width:191px']) !!}
        </div>
        <div>
        @if($errors->has('body'))
            <span class="require">*</span>{!! Form::textarea('body', null, ['class' => 'body error', 'style'=>'width:100%']) !!}
        @else
            <span class="require">*</span>{!! Form::textarea('body', null, ['class' => 'body', 'style'=>'width:98%']) !!}
        @endif
        </div>
        <div style="width: 100%;">
            <div style="width:100%; left: 0px; top: -3px; bottom: 0px">
                <div class="interests-title">
                    趣味
                </div>
                <div class="interests-parts">
                @foreach($interestsList as $row)
                    {!! Form::checkbox($row['name_tag'], $row['id'], false, ['id' => $row['name_tag']]) !!}
                    {!! Form::label($row['name_tag'], $row['name']) !!}
                @endforeach
                </div>
            </div>
        </div>
        <div class="file-selects">
            <div class="file-select">
                {!! Form::file('file1', ['id' => 'file1']) !!}
                {!! Form::file('file2', ['id' => 'file2']) !!}
            </div>
            <div class="post-btn-box">
                <span class="post-cancel-btn" style="display: none;"><a class="post-btn">キャンセル</a></span>
                <span id="post"><a class="post-btn">投稿する</a></span>
            </div>
            <div class="file-thumbnails">
                <span id="thumbnail1"></span>
                <span id="thumbnail2"></span>
            </div>
        </div>
    {!! Form::close() !!}
</div>