@include('template/head')
<div class="container">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Chart Example</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md">
            <div class="chart">
              <div id="container" style="min-height: 300px; height: 300px; max-height: 300px;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script src="https://code.highcharts.com/highcharts.js"></script>

<script>
// Data yang akan ditampilkan pada grafik
var data = [
    <?php
    // Loop melalui setiap nilai dalam $totalBookingHotel dan $bulan
    for ($i = 0; $i < count($totalDivisi); $i++) {
        echo '{';
        echo 'name: "' . $divisi[$i] . '",'; // Menggunakan nilai dari $bulan
        echo 'y: ' . $totalDivisi[$i]; // Menggunakan nilai dari $totalBookingHotel

        // Mengatur properti sliced dan selected untuk item pertama
        if ($i === 0) {
            echo ', sliced: true, selected: true';
        }

        echo '},';
    }
    ?>
];

// Membuat grafik bar chart
Highcharts.chart('container', {
    chart: {
        type: 'column' // Menggunakan tipe 'column' untuk membuat bar chart
    },
    title: {
        text: 'Grafik Transaksi ' // Judul grafik
    },
    xAxis: {
        categories: <?php echo json_encode($divisi); ?> // Menggunakan nama bulan sebagai kategori pada sumbu x
    },
    yAxis: {
        title: {
            text: 'Jumlah' // Label pada sumbu y
        }
    },
    series: [{
        name: 'Hotel',
        data: <?php echo json_encode($totalDivisi); ?> // Menggunakan data total booking untuk series
    }]
});
</script>


@include('template/foot')