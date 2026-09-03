@extends('layouts.al4_main')
@section('dashboard_mo', 'menu-open')
@section('dashboard', 'active')
@section('title', 'Dashboard')
@push('css')
@endpush
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Dashboard</a>
    </li>
@endsection

@section('maincontent')
    <div class="mt-3">
        <h2>{{ $userTitle }} DASHBOARD</h2>
        @include('partials.dboardstat')
        @include('partials.dboardchart')
        @include('partials.notice_calendar')
    </div>
@endsection
@push('js')
    <script src="{{ asset('custom/js/chart.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            //Line chart Admission trend start
            var obj = JSON.parse('<?php echo json_encode($newAdmissionCount); ?>');
            var ctx = document.getElementById('studentAdmission').getContext('2d');
            var labels = obj.map(function(e) {
                return e.class_name;
            });
            var data = obj.map(function(e) {
                return e.TotalNewAdmission;
            });
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'students',
                        data: data,
                        backgroundColor: window.chartColors.red,
                        borderColor: window.chartColors.red,
                        borderDash: [5, 5],
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            var male = JSON.parse('<?php echo json_encode($genderWiseNewAdmission['male']); ?>');
            var female = JSON.parse('<?php echo json_encode($genderWiseNewAdmission['female']); ?>');
            var other = JSON.parse('<?php echo json_encode($genderWiseNewAdmission['other']); ?>');

            var doughnutData = {
                labels: ["Male", "Female", "Other"],
                datasets: [{
                    data: [male, female, other],
                    backgroundColor: ["#0000b3", "#ffc0cb", "#b30000"]
                }]
            };

            var ctx4 = document.getElementById("doughnutChart").getContext("2d");
            new Chart(ctx4, {
                type: 'doughnut',
                data: doughnutData,
                options: doughnutOptions
            });


        });

        var doughnutOptions = {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true
            }
        };


        //End of Line chart Admission trend start

        window.chartColors = {
            red: 'rgb(255, 99, 132, 0.7)',
            orange: 'rgb(255, 159, 64, 0.7)',
            yellow: 'rgb(255, 205, 86, 0.7)',
            green: 'rgb(75, 192, 192, 0.7)',
            blue: 'rgb(54, 162, 235, 0.7)',
            purple: 'rgb(153, 102, 255, 0.7)',
            grey: 'rgb(201, 203, 207, 0.7)'
        };
    </script>
@endpush
