@extends('base_sp')

@section('content')
    <div ng-view></div>
    {{--<div style="position: relative">--}}
        {{--<article class="panel panel-primary" ng-repeat="article in articles">--}}
            {{--<div class="panel-heading">--}}
                {{--<h3 class="panel-title">@{{article.title}}</h3>--}}
            {{--</div>--}}
            {{--<div class="panel-body">--}}
                {{--@{{article.body}}--}}
            {{--</div>--}}
        {{--</article>--}}

        {{--<div class="create" ng-click="onPost()">--}}
            {{--<div class="sub_create">+</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@endsection