@extends('app-admin')

@section('content')

<div class="container" ng-controller="MatchesController">
    <div class="row">
        <div class="col-md-8">
            {!! Form::open() !!}
                <h3>1. Match information</h3>
                <div class="form-group">
                    <label for="team">Choose team</label>
                    <select class="form-control" id="team" name="team">
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="opponent">Choose opponent</label>
                    <select class="form-control" id="opponent" name="opponent">
                        @foreach($opponents as $opponent)
                            <option value="{{ $opponent->id }}">{{ $opponent->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="game">Choose game</label>
                    <select class="form-control" id="game" name="game">
                        @foreach($games as $game)
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                        @endforeach
                    </select>
                </div>
                <h3>2. Match Rounds</h3>
                <a href="#" ng-click="addRound()"><i class="fa fa-fw fa-plus-circle"></i> Add a round</a>
                <ul class="nav nav-pills" id="rounds">
                    <li ng-repeat="round in match.rounds"><a href="#round<% ($index + 1) %>" data-toggle="tab">Round <% ($index + 1) %></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="round<% ($index + 1) %>" ng-repeat="round in match.rounds">
                        <br/>
                        <div class="form-inline">
                            <div class="form-group" ng-repeat="score in round.scores">
                                <input type="text" class="form-control" placeholder="Team score" ng-model="score.score_home" />
                                <input type="text" class="form-control" placeholder="Opponent score" ng-model="score.score_guest" />
                                <select class="form-control" name="map">
                                    @foreach($maps as $map)
                                        <option value="{{ $map->id }}">{{ $map->name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-danger"><i class="fa fa-fw fa-minus-circle"></i></button>
                            </div>
                            <button class="btn btn-success"><i class="fa fa-fw fa-plus-circle"></i> Add score</button>
                        </div>
                        <br/>
                        <div class="form-group">
                            <label for="round-info">Round notes</label>
                            <textarea class="form-control" name="round-info" id="round-info" rows="4" ng-model="round.notes"></textarea>
                        </div>
                    </div>
                </div>
                <h3>3. Match links</h3>
            {!! Form::close() !!}
        </div>
        <div class="col-md-4">
            <div class="block">
                <h3>
                    Text block help
                    <small>Subtitle of text block</small>
                </h3>
                <div class="block-body">
                    Note that views which extend a Blade layout simply override sections from the layout. Content of the layout can be included in a child view using the directive in a section, allowing you to append to the contents of a layout section such as a sidebar or footer.
                </div>
            </div>
        </div>
    </div>
</div>

@endsection