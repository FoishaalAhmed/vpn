<?php include('session.php'); ?>
<?php $selectedMenu = "dashboard"; ?>
<?php include('templates/common/menubar.php'); ?>
<?php include('templates/dashboard_menu.php'); ?>
<?php include('templates/common/footer.php'); ?>
<script>
    $(document).ready(function() {
        showDonutGraph();
        showDonutTotimesGraph();
    });

    function showDonutGraph() {

        $.get("chart/getDonutChartData", function(data) {
            var name = [];
            var value = []

            for (var i in data.data) {
                name.push(data.data[i].title);
                value.push(data.data[i].value);
            }
            var ctx = $("#donutCanvas");
            var myChart = new Chart(ctx, {
                type: 'pie', //doughnut, pie
                data: {
                    labels: name,
                    datasets: [{
                        data: value,
                        backgroundColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 206, 86, 0.6)'
                        ],
                        hoverBackgroundColor: [
                            'rgba(54, 162, 235, 0.9)',
                            'rgba(255, 99, 132, 0.9)',
                            'rgba(255, 206, 86, 0.9)'
                        ],
                        borderWidth: 1,
                        hoverOffset: 2,
                    }]
                },
                options: {

                    plugins: {
                        responsive: true,
                        title: {
                            display: true,
                            text: "Server details",
                            color: '#2196f3',
                            font: {
                                family: 'Poppins',
                                size: 22,
                                weight: 'bold',
                                lineHeight: 1.2,
                            },
                            padding: {
                                top: 0,
                                left: 0,
                                right: 0,
                                bottom: 0
                            },
                        },
                        legend: {
                            display: true,
                            position: "bottom",
                            labels: {

                                font: {
                                    family: 'Poppins',
                                    size: 14,
                                },
                                boxWidth: 15,
                                usePointStyle: true,
                                pointStyle: "rectRounded",
                                padding: 25,
                            },
                        },
                        tooltip: {
                            bodyFont: {
                                family: 'Poppins',
                                size: 14,
                                lineHeight: 1.2,
                            },
                        }
                    },
                    responsive: false,
                    //cutout : '50%',
                    animation: {
                        animateScale: true
                    },
                }
            });
        });


    } //

    function showDonutTotimesGraph() {

        $.get("chart/getTotalHitCountData", function(data) {
            var name = [];
            var value = []

            for (var i in data.data) {
                name.push(data.data[i].serverName);
                value.push(data.data[i].hit_count);
            }
            var ctx = $("#donutCanvasTwo");
            var myChart = new Chart(ctx, {
                type: 'pie', //doughnut, pie
                data: {
                    labels: name,
                    datasets: [{
                        data: value,
                        backgroundColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(128, 128, 0, 1)',
                            'rgba(0, 128, 0, 1)'

                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(128, 128, 0, 0.6)',
                            'rgba(0, 128, 0, 0.6)'
                        ],
                        hoverBackgroundColor: [
                            'rgba(54, 162, 235, 0.9)',
                            'rgba(255, 99, 132, 0.9)',
                            'rgba(255, 206, 86, 0.9)',
                            'rgba(128, 128, 0, 0.9)',
                            'rgba(0, 128, 0, 0.9)'
                        ],
                        borderWidth: 1,
                        hoverOffset: 2,
                    }]
                },
                options: {

                    plugins: {
                        responsive: true,
                        title: {
                            display: true,
                            text: "Server Hit Count",
                            color: '#2196f3',
                            font: {
                                family: 'Poppins',
                                size: 22,
                                weight: 'bold',
                                lineHeight: 1.2,
                            },
                            padding: {
                                top: 0,
                                left: 0,
                                right: 0,
                                bottom: 0
                            },
                        },
                        legend: {
                            display: true,
                            position: "bottom",
                            labels: {

                                font: {
                                    family: 'Poppins',
                                    size: 14,
                                },
                                boxWidth: 15,
                                usePointStyle: true,
                                pointStyle: "rectRounded",
                                padding: 25,
                            },
                        },
                        tooltip: {
                            bodyFont: {
                                family: 'Poppins',
                                size: 14,
                                lineHeight: 1.2,
                            },
                        }
                    },
                    responsive: false,
                    //cutout : '50%',
                    animation: {
                        animateScale: true
                    },
                }
            });
        });


    } //
</script>