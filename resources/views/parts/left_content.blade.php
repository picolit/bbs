<div>
    <div class="search">

            {!! Form::open(['route' => 'articles.getIndex', 'method' => 'get']) !!}
                <div class="title">検索</div>
                <div class="search-interests">
                    <ui class="keep clearfix">
                    @foreach($interestsList as $row)
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
                                    {!! Form::label('見た目') !!}
                                </td>
                                <td>
                                    {!! Form::select('sex', $sexList) !!}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {!! Form::label('年齢') !!}
                                </td>
                                <td>
                                    {!! Form::select('age', $ageList) !!}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {!! Form::label('都道府県') !!}
                                </td>
                                <td>
                                    {!! Form::select('prefectures', $prefecturesList) !!}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {!! Form::label('地域') !!}
                                </td>
                                <td>
                                    {!! Form::select('area', $areaList) !!}
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