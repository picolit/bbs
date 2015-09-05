<div>
    <div class="search">

            {!! Form::open(['route' => 'articles.getIndex', 'method' => 'get']) !!}
                <div class="title">検索</div>
                <div class="search-interests">
                    <ui class="keep clearfix">
                    @foreach($interests as $row)
                        <li>
                        {!! Form::checkbox($row['name_tag'], $row['id'], isset($conditions[$row['name_tag']]), ['id' => $row['name_tag'].'_s']) !!}
                            <span>{!! Form::label($row['name_tag'].'_s', $row['name']) !!}</span>
                        </li>
                    @endforeach
                    </ui>
                    <div>
                        <table>
                            <tr>
                                <td>
                                    {!! Form::label('都道府県') !!}
                                </td>
                                <td>
                                    {!! Form::select('prefectures', $prefectures) !!}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {!! Form::label('地域') !!}
                                </td>
                                <td>
                                    {!! Form::select('area', [1 => '北海道']) !!}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div>
                    <div class="search-btn">{!! Form::submit('検 索', ['class' => 'btn btn-primary btn-block']) !!}</div>
                    <div class="reset-btn">{!! link_to('/', 'リセット', ['class' => 'btn btn-primary btn-block']) !!}</div>
                </div>
            {!! Form::close() !!}
        </div>
</div>