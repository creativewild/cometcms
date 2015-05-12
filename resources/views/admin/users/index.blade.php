@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/users/new') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> New user</a>
            </div>
            <form class="col-md-6" method="get" action="{{ url('admin/users') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Enter search term..." value="{{ !empty($searchTerm) ? $searchTerm : "" }}">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        @if(!empty($searchTerm))
                            <a class="btn btn-primary" href="{{ url('admin/users') }}"><i class="glyphicon glyphicon-remove"></i></a>
                        @endif
                    </span>
                </div>
            </form>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>@include('grid-header', ['action' => 'Admin\UsersController@index', 'name' => 'name', 'label' => 'Name'])</th>
                            <th>@include('grid-header', ['action' => 'Admin\UsersController@index', 'name' => 'email', 'label' => 'E-mail'])</th>
                            <th>@include('grid-header', ['action' => 'Admin\UsersController@index', 'name' => 'created_at', 'label' => 'Registered on'])</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><a href="{{ url('admin/users/edit', [$user->id]) }}">{{ $user->name }}</a></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d.m.Y') }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <a href="{{ url('admin/roles/edit', [$role->id]) }}">{{ $role->display_name }}</a><br>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ url('admin/users/delete', [$user->id]) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {!! $users->appends(['sort' => $sortColumn, 'order' => $order, 'search' => $searchTerm])->render() !!}
    </div>
@endsection