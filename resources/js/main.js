"use strict";

/**
 * Match viewmodels
 */
var MatchViewModel = function (matchData, metaData) {
    var self = this;

    self.match_id = ko.observable(matchData.id);
    self.opponent_id = ko.observable(matchData.opponent_id);
    self.team_id = ko.observable(matchData.team_id);
    self.game_id = ko.observable(matchData.game_id);
    self.rounds = ko.observableArray();
    self.games = ko.observableArray();

    // Fill in games and maps
    $.each(metaData, function (key, val) {
        self.games.push(new GameViewModel(val));
    });

    // Fill in the rounds
    if (matchData.rounds.length > 0) {
        $.each(matchData.rounds, function (key, val) {
            self.rounds.push(new RoundViewModel(self, val));
        });
    }
    else {
        self.rounds.push(new RoundViewModel(self, {}))
    }

    // Viewmodel computed properties
    self.matchRounds = ko.computed(function () {
        return '(BO' + self.rounds().length + ')';
    });

    self.getScore = ko.computed(function () {
        var homeScore = 0;
        var guestScore = 0;

        ko.utils.arrayForEach(self.rounds(), function (round) {
            ko.utils.arrayForEach(round.scores(), function (score) {
                homeScore += parseInt(isNaN(score.home()) ? 0 : score.home());
                guestScore += parseInt(isNaN(score.guest()) ? 0 : score.guest());
            });
        });

        return [homeScore, guestScore];
    });

    self.finalScore = ko.computed(function () {
        return self.getScore()[0] + ':' + self.getScore()[1];
    });

    self.outcome = ko.computed(function () {
        if (self.getScore()[0] > self.getScore()[1])
            return 'win';
        else if (self.getScore()[0] < self.getScore()[1])
            return 'lose';
        else
            return 'draw';
    });

    self.outcomeClass = ko.computed(function () {
        if (self.getScore()[0] > self.getScore()[1])
            return 'label-success';
        else if (self.getScore()[0] < self.getScore()[1])
            return 'label-danger';
        else
            return 'label-warning';
    });

    // Viewmodel methods
    self.addRound = function () {
        self.rounds.push(new RoundViewModel(self, {scores: []}));
    };

    self.removeRound = function (round) {
        self.rounds.remove(round);
    };
};

var RoundViewModel = function (parent, roundsData) {
    var self = this;

    self.round_id = ko.observable(roundsData.id);
    self.match_id = ko.observable(parent.match_id);
    self.map_id = ko.observable(roundsData.map_id);
    self.scores = ko.observableArray();
    self.notes = ko.observable(roundsData.notes);
    self.maps = ko.observableArray(parent.games().filter(function(game) { return game.game_id() == 3; })[0].maps());

    // Fill in the scores
    if (roundsData.scores.length > 0) {
        $.each(roundsData.scores, function (key, val) {
            self.scores.push(new ScoreViewModel(self, val));
        });
    }
    else {
        self.scores.push(new ScoreViewModel(self, {}))
    }

    // Viewmodel methods
    self.addScore = function () {
        self.scores.push(new ScoreViewModel(self, {}));
    };

    self.removeScore = function (score) {
        self.scores.remove(score);
    };
};

var ScoreViewModel = function (parent, scoreData) {
    var self = this;

    self.score_id = ko.observable(scoreData.id);
    self.round_id = ko.observable(parent.round_id);
    self.home = ko.observable(scoreData.home);
    self.guest = ko.observable(scoreData.guest);
};

var GameViewModel = function(data) {
    var self = this;

    self.game_id = ko.observable(data.id);
    self.name = ko.observable(data.name);
    self.code = ko.observable(data.code);
    self.image = ko.observable(data.image);
    self.maps = ko.observableArray();

    $.each(data.maps, function (key, val) {
        self.maps.push(new MapViewModel(self, val));
    });
};

var MapViewModel = function(parent, data) {
    var self = this;

    self.game_id = parent.game_id;
    self.map_id = ko.observable(data.id);
    self.image = ko.observable(data.image);
    self.name = ko.observable(data.name);
}

$(document).ready(function ()
{
    /**
     * Data binding
     */
    var defaultModelData = {rounds: [{scores: [], notes: null}]};
    
    console.log('Loading viewmodel...');
    if (matchData) {
        matchViewModel = new MatchViewModel(matchData, metaData);
        
    }
    else {
        matchViewModel = new MatchViewModel(defaultModelData, metaData);
    }
    console.log('Viewmodel loaded!');
    console.log(matchViewModel);

    ko.applyBindings(matchViewModel, document.getElementById('match-form'));

    /**
     * Events
     */
    $('#match-form').submit(function (ev) {
        ev.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });
        var data = ko.toJSON(matchViewModel);
        var posting = null;

        if ($.isNumeric(matchID)) {
            posting = $.post("/admin/matches/edit/" + matchID, {data: data});
        }
        else {
            posting = $.post("/admin/matches/new", {data: data});
        }

        posting.done(function (resp) {
            console.log(resp.alerts[0].message);
            window.location.href = resp.location;
        });
    });
});