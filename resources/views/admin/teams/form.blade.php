@extends('admin.app-admin')

@section('pagebar-buttons')
    <div class="col-md-6 text-right">
        <a href="#" class="btn btn-default"><i class="fa fa-fw fa-shield"></i> Match history</a>
        <a href="#" class="btn btn-default"><i class="fa fa-fw fa-line-chart"></i> Statistics</a>
    </div>
@endsection

@section('content')
    <div class="container">
        {!! Form::open(['id' => 'squad-form', 'class' => 'row', 'files' => true]) !!}
            <div class="col-md-12">
                <div class="section section-main">
                    <div class="row">
                        <div class="col-md-6 col-no-padding-right">
                            <div class="form-group form-group-inline">
                                <label for="name" class="control-label">Squad name</label>
                                <input type="text" id="name" name="name" class="form-control" minlength="3" data-bind="value: name" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-no-padding-left">
                            <div class="form-group fg-connector form-group-inline">
                                <label for="game" class="control-label">Primary game</label>
                                <select class="form-control games-dropdown" id="game" name="game" data-bind="value: game_id">
                                    @foreach($games as $game)
                                        <option value="{{ $game->id }}" data-icon="{{ $game->image }}">{{ $game->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-inline">
                                <label for="description" class="control-label">Description</label>
                                <textarea name="description" id="description" rows="4" class="form-control" data-bind="value: description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-inline">
                                <label for="image" class="control-label">Image</label>
                                <input class="form-control" type="file" name="image" id="image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section section-main">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                    <input class="form-control" type="text" placeholder="Start typing to find and add members..." data-bind="value: search_string">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info" type="button" data-bind="click: findUsers, attr: {disabled: searching()}">Find! <i class="fa fa-spinner fa-pulse" data-bind="css: {hide: !searching()}"></i></button>
                                    </span>
                                </div>
                                <ul class="list-group" data-bind="foreach: found_users">
                                    <li class="list-group-item"><button class="btn btn-success btn-xs" data-bind="click: addToMembers"><i class="fa fa-plus-circle"></i></button> <!--ko text: name--><!--/ko--></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" data-bind="foreach: members">
                            <div class="squad-member">
                                <img alt="Avatar" data-bind="attr: {src: '/uploads/users/' + image()}">
                                <button class="btn btn-xs btn-corner btn-overlay" data-bind="click: removeFromMembers"><i class="fa fa-remove"></i></button>
                                <div class="squad-member-info">
                                    <h4 data-bind="text: name"></h4>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-dark" placeholder="Player position..." data-bind="value: position">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-dark" placeholder="Player status..." data-bind="value: status">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-dark btn-block" data-bind="css: {'btn-captain-active': captain}, click: toggleCaptain">
                                            <i class="fa fa-star"></i> Captain
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($history)
                    <div class="row">
                        <div class="col-md-2"><h4 class="form-subtitle">Roster history</h4></div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-12">
                                    @foreach($history as $historyDate => $members)
                                        <h3>{{ $historyDate }}</h3>
                                        <ul class="list-group">
                                            @foreach($members as $member)
                                                <li class="list-group-item">{{ $member->name }} ({{ $member->position }})</li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                @endif
                <div class="text-right">
                    @if($team)
                    <a href="{{ url('admin/teams/delete', ['id' => $team->id]) }}" class="btn btn-danger" data-confirm="Are you sure you want to delete this squad?">Delete squad</a>
                    @endif
                    <a href="/admin/teams" class="btn btn-default">Cancel</a>
                    <button id="save-squad" class="btn btn-success" type="submit">Save <i class="fa fa-chevron-right"></i></button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('page-scripts')
    <script src="{{ asset('/js/admin/lib/select2.full.min.js') }}"></script>
    <script src="{{ asset('/js/admin/modules/teams.js') }}"></script>
@endsection