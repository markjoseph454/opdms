@component('partials/header')

    @slot('title')
        OPD | Login
    @endslot

    @section('pagestyle')
        <link href="{{ asset('public/css/partials/login.css') }}" rel="stylesheet" />
    @stop



    @section('header')
    @stop



    @section('content')
    <div class="container-fluid loginWrapper">
        <div class="container">
            <div class="row">
                <div class=" col-md-3 logoWrapper">
                    <img src="{{ asset('public/images/doh-logo2.png') }}" class="img-responsive" />
                    <img src="{{ asset('public/images/evrmc-logo.png') }}" class="img-responsive" />
                </div>
                <div class="col-md-9 loginBannerTitle">
                    <h3>Eastern Visayas Regional Medical Center</h3>
                    <h1>OUTPATIENT RECORD MANAGEMENT SYSTEM</h1>
                </div>
            </div>

            <br/>
            <br/>
            <br/>

            <div class="row">
                <form action="{{ url('login') }}" method="post">
                    <div class="container">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="row">
                                <h1 class="text-center">Secure Login</h1>
                                <br/>

                                    @include('message.msg')

                                    {{ csrf_field() }}

                                    <div class="form-group @if($errors->has('username')) has-error @endif">
                                        <div class="input-group">
                                            <input type="text" name="username" value="{{ old('username') }}" class="form-control"
                                            placeholder="Enter Username" aria-describedby="usernameaddon" autofocus />
                                            <span class="input-group-addon addonIcon" id="usernameaddon">
                                                <i class="fa fa-user"></i>
                                            </span>
                                        </div>
                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                                <strong class="">{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <br/>

                                    <div class="form-group @if($errors->has('password')) has-error @endif">
                                        <div class="input-group">
                                        <input type="password" id="pass_input" name="password" class="form-control" placeholder="Enter Password"
                                        aria-describedby="passwordaddon" />
                                        <span class="input-group-addon addonIcon" id="passwordaddon">
                                                <i class="fa fa-unlock-alt"></i>
                                            </span>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong class="">{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <p class="capslockon">
                                        <i class="fa fa-warning"></i>
                                        Caps Lock is on.
                                    </p>

                                    <div class="form-group">
                                        <br/>
                                        <button type="submit" class="btn btn-block btn-default">
                                            Login <i class="fa fa-sign-in"></i>
                                        </button>
                                    </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
        
    @endsection





    @section('footer')
    @stop



    @section('pagescript')
        @include('message.toaster')
        <script src="{{ asset('public/js/partials/login.js') }}"></script>
    @stop


@endcomponent
