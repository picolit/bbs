@extends('base')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2>Login Using Social Sites</h2>
            <a class="btn btn-primary" href="{{ route('social.login.getAuthorize', ['github']) }}">Github</a>
            <a class="btn btn-primary" href="{{ route('social.login.getAuthorize', ['facebook']) }}">Facebook</a>
            <a class="btn btn-primary" href="{{ route('social.login.getAuthorize', ['google']) }}">Google</a>
        </div>
    </div>
@endsection

@section('inline-script')
    @parent
@endsection

