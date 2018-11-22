@component('OPDMS.partials.header')


    @slot('title')
        Update Account
    @endslot


@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_queue.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/partials/patient_information.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/patient_assignation.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/OPDMS/css/reception/notification.css') }}" />
@endsection



{{-- vue element start of div --}}
@section('vue-container-start')
    <div id="vue-queue">
@endsection





    @section('navigation')
        @include('OPDMS.partials.boilerplate.navigation')
    @endsection


    @section('dashboard')
        @component('OPDMS.partials.boilerplate.dashboard')
            @section('search_form')
                @if(Auth::user()->role == 5) {{-- reception ui --}}
                    @include('OPDMS.reception.partials.search_form')
                @endif
            @endsection
        @endcomponent
    @endsection



    @section('content')





        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper patient_queue_wrapper">



            @include('OPDMS.partials.boilerplate.header',
            ['header' => 'Update Account', 'sub' => 'Change your account information.'])

            <!-- Main content -->
                <section class="content container-fluid">

                    <div class="box box-default bg-danger" id="registerWrapper">


                        <div class="box-body">
                            <div class="col-md-6 col-md-offset-3">

                                <form action="{{ url('account/'.$user->id) }}" method="post" enctype="multipart/form-data">

                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}

                                    <input type="hidden" name="id" value="{{ $user->id }}" />

                                    <div class="form-group text-center @if($errors->has('profile')) has-error @endif">

                                        @if($user->profile)
                                            @php
                                                $src = asset('public/users/'.$user->profile);
                                            @endphp
                                        @else
                                            @php
                                                $src = asset('public/images/user.svg')
                                            @endphp
                                        @endif
                                        <img src="{{ $src }}" class="img-responsive img-circle img-thumbnail center-block" />

                                        @if ($errors->has('profile'))
                                            <span class="help-block">
                                                {{ $errors->first('profile') }}
                                            </span>
                                        @endif
                                        <br>
                                        <label class="btn btn-default btn-file text"
                                               title="Click to upload your profile picture"
                                               data-placement="left" data-container="body"
                                               data-toggle="tooltip">
                                            Upload Profile Picture
                                            <i class="fa fa-file-image-o"></i>
                                            <input type="file" name="profile" style="display: none;">
                                        </label>
                                        <span class="help-block fileDisplay"></span>
                                    </div>

                                    <br>

                                    <div class="form-group @if($errors->has('last_name')) has-error @endif">
                                        <label for="">Last Name</label>
                                        <input type="text" name="last_name" class="form-control text-uppercase"
                                               value="{{ $user->last_name }}"
                                               placeholder="Please Enter Last Name" />
                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                                {{ $errors->first('last_name') }}
                                            </span>
                                        @endif
                                    </div>


                                            <div class="form-group @if($errors->has('first_name')) has-error @endif">
                                                <label>First Name</label>
                                                <input type="text" name="first_name" class="form-control text-uppercase"
                                                       value="{{ $user->first_name }}"
                                                       placeholder="Please Enter First Name" />
                                                @if ($errors->has('first_name'))
                                                    <span class="help-block">
                                                        {{ $errors->first('first_name') }}
                                                    </span>
                                                @endif
                                            </div>


                                    <div class="form-group @if($errors->has('middle_name')) has-error @endif">
                                        <label>Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control text-uppercase"
                                               value="{{ $user->middle_name }}"
                                               placeholder="Please Enter Middle Name" />
                                        @if ($errors->has('middle_name'))
                                            <span class="help-block">
                                                 {{ $errors->first('middle_name') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group @if($errors->has('username')) has-error @endif">
                                        <label>Username</label>
                                        <input type="text" name="username"
                                               class="form-control" value="{{ $user->username }}"
                                               placeholder="Please Enter Username" />
                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                                {{ $errors->first('username') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group @if($errors->has('password')) has-error @endif">
                                        <label>New Password</label>
                                        <input type="password" name="password" class="form-control password"
                                               placeholder="Please Enter New Password" />
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                {{ $errors->first('password') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>Confirm New Password</label>
                                        <input type="password" name="password_confirmation" class="form-control password"
                                               placeholder="Please Confirm New Password" />
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-flat btn-sm btn-default" toggle="on" id="showPassword">
                                            Show <i class="fa fa-eye"></i>
                                        </button>
                                        <button class="btn btn-flat btn-sm btn-default" id="generatePassword">
                                            Generate Password <i class="fa fa-key"></i>
                                        </button>
                                    </div>

                                    <div class="form-group @if($errors->has('old_password')) has-error @endif">
                                        <label>Old Password</label>
                                        <input type="password" name="old_password" class="form-control"
                                               placeholder="Please Enter Old Password" />
                                        @if ($errors->has('old_password'))
                                            <span class="help-block">
                                                {{ $errors->first('old_password') }}
                                            </span>
                                        @endif
                                    </div>


                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-flat btn-success btn-loading">
                                            Submit & Save
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>

                        <div class="box-footer">
                            <small>
                                <em class="text-muted">
                                    Change your account information.
                                </em>
                            </small>
                        </div>

                    </div>



                </section>
                <!-- /.content -->

            </div>
            <!-- /.content-wrapper -->
        @endsection



        @section('footer')
            @include('OPDMS.partials.boilerplate.footer')
        @endsection



        @section('aside')
            @include('OPDMS.partials.boilerplate.aside')
        @endsection



{{-- vue element end of div --}}
@section('vue-container-end')
    </div>
@endsection


@section('pluginscript')
@endsection


@section('pagescript')
    <script src="{{ asset('public/OPDMS/vue/reception/queue.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/reception/notification.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/partials/register.js') }}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
@endsection


@endcomponent