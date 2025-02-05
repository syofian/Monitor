@include('template/head')

<div class="container">
<div class="card card-primary">
<div class="card-header">
        <span>Traffic Pengguna</span>
    </div>
<div class="card-body">
    <!-- Elemen untuk memilih rentang tanggal -->
   <div class="d-flex">
    <input type="date" id="startDate" class="form-control" name="startDate">
    <input type="date" id="endDate" class="form-control" name="endDate">
    <button class="btn btn-primary h-7 form-control" onclick="filterData()">Terapkan</button>
</div>
    <!-- Elemen untuk menampilkan diagram batang -->
    <div id="container" style="width: 100%; height: 400px;"></div>
</div>
</div>
    
    <script src="https://code.highcharts.com/10/highcharts.js"></script>
    <script>
   
   var coba = <?php echo json_encode($total); ?>;

// Mengambil semua nilai 'jml' dan 'tgl' menggunakan map()




               // console.log(coba); // Check the value of tes
        console.log(coba); // Check the value of teh

        // Data pengguna per hari, contoh data inisiasi terpisah (bisa diambil dari API atau database)
        // var dataPengguna = [
        //     { date: '2025-02-01', users: 120 },
        //     { date: '2025-02-02', users: 150 },
        //     { date: '2025-02-03', users: 90 },
        //     { date: '2025-02-04', users: 130 },
        //     { date: '2025-02-05', users: 160 },
        //     // Tambahkan data lainnya
        // ];
        // console.log(dataPengguna); // Check the value of teh


        // Fungsi untuk memfilter data berdasarkan rentang tanggal
        function filterData() {
            var startDate = document.getElementById("startDate").value;
            var endDate = document.getElementById("endDate").value;

            // Filter data sesuai rentang tanggal yang dipilih
            var filteredData = coba.filter(function(item) {
                return item.tgl >= startDate && item.tgl <= endDate;
            });

            // Render grafik dengan data yang telah difilter
            renderChart(filteredData);
        }

        // Fungsi untuk merender chart
        function renderChart(data) {
            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Jumlah Pengguna per Hari'
                },
                xAxis: {
                    categories: data.map(function(item) { return item.jml; }),
                    title: {
                        text: 'Tanggal'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Pengguna'
                    }
                },
                series: [{
                    name: 'Pengguna',
                    data: data.map(function(item) { return item.tgl; })
                }]
            });
        }

        // Inisialisasi chart pertama kali dengan semua data
        renderChart(coba);
    </script>

@include('template/foot')
