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
                                {!! Form::select('sex_s', $sexList) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('年齢') !!}
                            </td>
                            <td>
                                {!! Form::select('age_s', $ageList) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('都道府県') !!}
                            </td>
                            <td>
                                {!! Form::select('prefectures_s', $prefecturesList) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('地域') !!}
                            </td>
                            <td>
                                {!! Form::select('area_s', $areaList) !!}
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

    <div class="contents-link">
        <div class="title">リンク</div>
        <div class="links">
            <ul>
                @foreach($links as $link)
                <li>
                    {!! $link !!}
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div>
        <!-- Rakuten Widget FROM HERE --><script type="text/javascript">rakuten_design="slide";rakuten_affiliateId="13ed97bb.2bd40133.13ed97bc.3f8c0543";rakuten_items="ranking";rakuten_genreId=0;rakuten_size="300x250";rakuten_target="_blank";rakuten_theme="gray";rakuten_border="on";rakuten_auto_mode="on";rakuten_genre_title="off";rakuten_recommend="on";</script><script type="text/javascript" src="http://xml.affiliate.rakuten.co.jp/widget/js/rakuten_widget.js"></script><!-- Rakuten Widget TO HERE -->
    </div>
</div>