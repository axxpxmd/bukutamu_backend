<div class="p-0">
    <div class="chart-pie">
        <canvas id="myChart"></canvas>
        <span></span>
    </div>
    <div class="mt-4 text-center small">
        <span class="mr-2">
            <i class="icon icon-circle text-success"></i> Gojek
        </span>
        <span class="mr-2">
            <i class="icon icon-circle text-primary"></i> Grab
        </span>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: ["Grab", "Gojek"],
        datasets: [{
            backgroundColor: ['#2979FF', '#1cc88a'],
            data: [{{ $grab }}, {{ $gojek }}],
        }]
    },

    // Configuration options go here
    options: {
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#000000",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: false
        },
        cutoutPercentage: 60,
    }
});
</script>
