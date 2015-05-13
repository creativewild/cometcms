@extends('app-admin')

@section('content')
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/matches/new') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> New match</a>
            </div>
            <form class="col-md-6" method="get" action="{{ url('admin/matches') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Enter search term..." value="{{ !empty($searchTerm) ? $searchTerm : "" }}" tabindex="1">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        @if(!empty($searchTerm))
                            <a class="btn btn-primary" href="{{ url('admin/matches') }}"><i class="glyphicon glyphicon-remove"></i></a>
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
                            <th>@include('grid-header', ['action' => 'Admin\MatchesController@index', 'name' => 'created_at', 'label' => 'Played on'])</th>
                            <th>@include('grid-header', ['action' => 'Admin\MatchesController@index', 'name' => 'team', 'label' => 'Team'])</th>
                            <th>@include('grid-header', ['action' => 'Admin\MatchesController@index', 'name' => 'opponent', 'label' => 'Versus'])</th>
                            <th>@include('grid-header', ['action' => 'Admin\MatchesController@index', 'name' => 'game', 'label' => 'Game'])</th>
                            <th>Outcome</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $match)
                            <tr>
                                <td><a href="{{ url('admin/matches/edit', [$match->id]) }}">{{ $match->created_at->format('d.m.Y H:i:s') }}</a></td>
                                <td>{{ $match->team->name }}</td>
                                <td>{{ $match->opponent->name }}</td>
                                <td>{{ $match->game->name }}</td>
                                <td>WIN</td>
                                <td>
                                    <a href="{{ url('admin/matches/delete', [$match->id]) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this match?');">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {!! $data->appends(['sort' => $sortColumn, 'order' => $order, 'search' => $searchTerm])->render() !!}
    </div>
@endsection