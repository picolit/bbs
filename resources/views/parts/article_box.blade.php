<div id="id{{$row->id}}" class="{{$class}}">
    <div class="article-header">
        <div class="article-header-01">
            @if ($row->mail)
            <span class="name">{!! link_to_route('articles.getMailSend', $row->name, [$row->id]) !!}</span>
            @else
            <span class="name">{{ $row->name }}</span>
            @endif
            <span class="sex">{{ const_value('sex', $row->sex) }}</span>
            <span class="age">{{ const_value('age', $row->age) }}</span>
            <span class="prefectures">{{ const_value('prefectures', $row->prefectures) }}</span>
        </div>
        <div class="article-header-02">
            @if($row->password)
            <a onClick="articleDelete({{$row->id}})">削除</a>
            @endif
        </div>
    </div>
    <hr>
    <div>
        <span class="article-title">{{ $row->title}}</span>
    </div>
    <div class="interest">
        <div class="on article-interest-title">興味</div>
        <div class="article-interest-value">
            @foreach($interestsList as $val)
                @if(in_array($val->name_tag, $row->interests->pluck('name_tag')->toArray()))
                    <a class="on" href="#">{{ $val->name }}</a>
                @else
                    <span class="off">{{ $val->name }}</span>
                @endif
            @endforeach
        </div>
    </div>
    <hr style="clear:left">
    <div class="article-body">
        {!! nl2br(htmlentities($row->body)) !!}
    </div>
    @if(!$row->photos->isEmpty())
        <hr>
    @endif
    <div class="article-photo">
        @foreach($row->photos as $photoRow)
            <a href="{{ $original_img_path.$photoRow->file_name}}">{!! Html::image($thumbnail_img_path.$photoRow->file_name, null,['style' => 'height:130px']) !!}</a>
        @endforeach
    </div>
    <hr>
    <div>
        <div class="article-footer">
                <div class="replay-btn">
                    @if(!$isReply)
                        <div class="reply"><a data-id="{{$row->id}}" href="javascript:void(0)">返 信</a></div>
                    @endif
                </div>
                <div class="nice-box">
                    <div>
                        @inject('niceService', 'App\Service\NiceService')
                        @if($niceService->isNice($userId, $row->id))
                            <span class="nice-end-btn">エロいいね済</span>
                        @else
                            <span class="nice-btn" data-id="{{$row->id}}"><a href="javascript:void(0)" data-url="{{route('articles.postNice', ['id' => $row->id, 'user_id' => $userId])}}">エロいいね！</a></span>
                        @endif
                    </div>
                </div>
                <div class="nice-count"><span>{{$row->nices->count()}}</span>人がエロイイネと言っています</div>
                <div class="created-at"><span class="created-at">{{$row->created_at}}</span></div>
        </div>
    </div>
</div>