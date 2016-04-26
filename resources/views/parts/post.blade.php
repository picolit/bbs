<div class="post-form" style="display: {{ $display }}" id="{{$article_id}}">
    {{--<div class="post-title">新規投稿</div>--}}
    {!! Form::open(['id' => 'myForm', 'class' => 'my-form', 'files' => true]) !!}

        {!! Form::hidden('parent_id', 0) !!}

        <div style="margin-bottom: 5px">
            <span class="require">*</span>{!! Form::text('name', null, ['id' => 'name', 'class' => 'input', 'placeholder' => 'お名前（必須）']) !!}
            <span class="require">*</span>{!! Form::text('title', null, ['id' => 'title', 'class' => 'input', 'placeholder' => 'タイトル（必須）', 'style' => 'width:200px']) !!}
            {!! Form::text('password', null, ['id' => 'password', 'class' => 'input', 'placeholder' => 'パスワード', 'style' => 'width:145px']) !!}
        </div>
        <div>
            <span class="require">*</span>{!! Form::select('sex', $sexList, null, ['id' => 'sex', 'class' => 'input']) !!}
            <span class="require">*</span>{!! Form::select('age', $ageList, null, ['id' => 'age', 'class' => 'input']) !!}
            <span class="require">*</span>{!! Form::select('prefectures', $prefecturesList, null, ['id' => 'prefectures', 'class' => 'input']) !!}
            {!! Form::email('mail', null, ['id' => 'mail', 'placeholder' => 'メールアドレス', 'style' => 'width:191px', 'class' => 'input']) !!}
        </div>
        <div><span class="require">*</span>{!! Form::textarea('body', null, ['id' => 'body', 'class' => 'body input', 'style'=>'width:98%']) !!}
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
                <div style="float: left">
                    {!! Form::file('file1', ['id' => 'file1', 'accept' => 'image/*', 'class' => 'input']) !!}
                    @if($errors->has('file1'))
                        <div class="require">{{ $errors->first('file1') }}</div>
                    @endif
                </div>
                <div style="float: left">
                    {!! Form::file('file2', ['id' => 'file2', 'class' => 'input']) !!}
                    @if($errors->has('file2'))
                        <div class="require">{{ $errors->first('file1') }}</div>
                    @endif
                </div>
            </div>
            <div class="post-btn-box">
                <span class="post-cancel-btn" style="display: none;"><a class="post-btn">キャンセル</a></span>
                <span id="post"><a class="post-btn">投稿する</a></span>
            </div>
            <div class="file-thumbnails">
                <canvas id="canvas1" style="display:none"></canvas>
                <canvas id="canvas2" style="display:none"></canvas>
                <span id="thumbnail1"></span>
                <span id="thumbnail2"></span>
            </div>
        </div>
    {!! Form::close() !!}
</div>