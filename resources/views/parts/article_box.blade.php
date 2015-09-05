<div id="id{{$row->id}}" class="{{$class}}">
    <div class="poster-info">
        <span class="name">{{ $row->name }}</span>
        <span class="sex">{{ const_value('sex', $row->sex) }}</span>
        <span class="age">{{ const_value('age', $row->age) }}</span>
    </div>
    <div class="interest">
        <span class="on">興味</span>

        @foreach($interests as $val)
            @if(in_array($val->name_tag, $row->interests->pluck('name_tag')->toArray()))
                <a class="on" href="#">{{ $val->name }}</a>
            @else
                <span class="off">{{ $val->name }}</span>
            @endif
        @endforeach
    </div>
    <div>
        <span class="article-title">{{ $row->title}}</span>
    </div>
    <hr>
    <div class="article-body">
        {!! nl2br(htmlentities($row->body)) !!}
    </div>
    <div>
        @foreach($row->photos as $photoRow)
            <a href="{{ $original_img_path.$photoRow->file_name}}">{!! Html::image($thumbnail_img_path.$photoRow->file_name, null,['style' => 'height:100px']) !!}</a>
        @endforeach
    </div>
    <div>
        <table class="article-footer">
            <tr>
                <td style="width: 10%">
                    @if(!$isReply)
                        <div class="reply"><a data-id="{{$row->id}}" href="javascript:void(0)">返 信</a></div>
                    @endif
                </td>
                <td style="width: 50%">
                    <div class="nice">
                        @inject('niceService', 'App\Service\NiceService')
                        @if($niceService->isNice($userId, $row->id))
                            <span class="nice-end-btn">エロいいね済</span>
                            <span class="nice-count">{{ $row->nices->count() }}人がエロイイネと言っています。</span>
                        @else
                            <span class="nice-btn">
                                <a data-url="{{route('articles.postNice', ['id' => $row->id, 'user_id' => $userId])}}">
                                    エロいいね！
                                </a>
                                <span class="nice-count">{{ $row->nices->count() }}人がエロイイネと言っています。</span>
                            </span>
                        @endif

                    </div>
                </td>
                <td style="text-align: right">
                    <div class="created-at">{{ $row->created_at}}</div>
                </td>
            </tr>
        </table>
    </div>
</div>