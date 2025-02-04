@include('template/head')


<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Grafik Penjualan</div>
        <div class="card-body">
          <div id="grafik"></div>
        </div>
      </div>
    </div>
  </div>
  
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
  var pendapatan = <?php echo json_encode($totalBookingHotel) ?>  ;
  var bulan = <?php echo json_encode($bulan) ?>  ;
  Highcharts.chart('grafik' , {
    title: {
      text: 'Grafik Pendapatan Bulanan'
    },
    xAxis: {
      categories: bulan
    },
    yAxis: {
      title: {
        text: 'Nominal Pendapatan'
      }
    },
    plotOptions: {
      series: {
        allowPointSelect: true
      }
    },
    series: [{
      name: 'Nominal Pendapatan',
      data: pendapatan
    }]
  });
</script>

@include('template/foot')