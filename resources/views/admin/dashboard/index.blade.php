@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Matches</div>
                    <div class="panel-body">
                        Won: 1, lose, 2, draw,3
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Your next match</div>
                    <div class="panel-body">
                        Event, date, time, info
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ date('Y') }} Match statistics</div>
                    <div class="panel-body">
                        <canvas id="matches-graph" style="width: 100%; height: 200px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts-before')
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
@endsection
@section('page-scripts')
    <script>
        var options = {
            responsive: true
        };

        var data = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
                {
                    label: "Lost",
                    fillColor: "rgba(255,0,0,0.2)",
                    strokeColor: "rgba(255,0,0,1)",
                    pointColor: "rgba(255,0,0,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(255,0,0,1)",
                    data: [5, 3, 6, 7, 2, 4, 6]
                },
                {
                    label: "Won",
                    fillColor: "rgba(0,255,0,0.2)",
                    strokeColor: "rgba(0,255,0,1)",
                    pointColor: "rgba(0,255,0,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(0,255,0,1)",
                    data: [7, 4, 1, 7, 3, 8, 9]
                },
                {
                    label: "Draw",
                    fillColor: "rgba(255,255,0,0.2)",
                    strokeColor: "rgba(255,255,0,1)",
                    pointColor: "rgba(255,255,0,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(255,255,0,1)",
                    data: [2, 1, 3, 2, 1, 0, 1]
                }
            ]
        };

        var ctx = $("#matches-graph").get(0).getContext("2d");
        var matchesChart = new Chart(ctx).Bar(data);
    </script>
@endsection