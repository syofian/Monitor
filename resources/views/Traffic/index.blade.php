@include('template/head')

<div class="container">
<div class="card card-primary">
<div class="card-header">
        <span>Traffic Pengguna</span>
    </div>
    <br>
<div class="card-body">
    <!-- Elemen untuk memilih rentang tanggal -->
   <div class="d-flex">
   <form action="{{ route('traffic') }}" method="GET" class="d-flex gap-3 align-items-center" style="width: 400px;">
                
                <input type="date" name="startDate" value="{{ request('startDate') }}" class="form-control">
                <input type="date" name="endDate" value="{{ request('endDate') }}" class="form-control">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
</div>
    <!-- Elemen untuk menampilkan diagram batang -->
    <div id="container" style="width:100%; height:400px;"></div>
    </div>
</div>
    
<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">

    
        var data = @json($total); // Mengambil data dari controller
        var urutCateg = data.sort((a, b) => new Date(a.tgl) - new Date(b.tgl));  // Sort by date (ascending)
        var urutValues = data.sort((a, b) => parseInt(a.jml) - parseInt(b.jml));  // Sort by quantity (ascending)

        // Map the sorted data
        var categories = urutCateg.map(item => item.tgl);  // Extract sorted dates
        var values = urutValues.map(item => parseInt(item.jml));  // Extract sorted quantities

console.log(categories); // Sorted dates
console.log(values);     // Sorted quantities


        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Traffic Pengguna'
            },
            xAxis: {
                categories: categories,
                title: {
                    text: 'Tanggal'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Transaksi',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' Transaksi'
            },
            series: [{
                name: 'Report Traffic',
                data: values
            }]
        });
        
</script>
<script>
    document.getElementById('myForm').addEventListener('submit', function(event) {
    var startDate = document.getElementById('startDate').value;
    var endDate = document.getElementById('endDate').value;
    
    // Jika endDate lebih kecil dari startDate
    if (new Date(endDate) < new Date(startDate)) {
        // Menampilkan pesan kesalahan
        alert("End Date cannot be earlier than Start Date.");
        event.preventDefault();  // Mencegah form dikirim
    }
});

</script>
@include('template/foot')
