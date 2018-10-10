@component('partials/header')

    @slot('title')
        OPD | Register
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
@stop



@section('header')
    @include('admin/navigation')
@stop



@section('content')
    <div class="container">
        <h2 class="text-center">USERLIST</h2>
        <br>
        <div class="table-responsive">
            <table class="table" id="userlistTable">
                <thead>
                    <tr class="bg-default">
                        <th>#</th>
                        <th>STATUS</th>
                        <th>NAME</th>
                        <th>USERNAME</th>
                        <th>CLINIC</th>
                        <th>ROLE</th>
                        <th>EDIT</th>
                        <th>TRASH</th>
                        <th>DECRYPT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                {!! (App\User::isActive($user->id))? '<div class="online"></div>' : '<div class="offline"></div>' !!}
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->clinicname }}</td>
                            <td>{{ $user->roledesc }}</td>
                            <td>
                                <a href="{{ url('editUser/'.$user->id) }}" class="btn btn-circle text-info">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-circle text-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ url('decrypt/'.$user->id) }}" class="btn btn-circle text-warning" onclick="decryptPassword($(this))">
                                    <i class="fa fa-key"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <br><br>



@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/admin/decrypt.js') }}"></script>
@stop


@endcomponent
