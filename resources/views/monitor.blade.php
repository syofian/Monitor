<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor</title>
    <!-- Link ke file CSS DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <style>
        /* Menambahkan border ke seluruh tabel dan sel */
        table {
           
            margin: 20px auto;
            border-collapse: collapse; /* Menggabungkan batas sel */
        }

        th, td {
            border: 2px solid #ddd;  /* Menambahkan border ke setiap sel */
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        table thead {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
<h1 style="text-align: center;">Status Monitor</h1>
<div style="display: flex; justify-content: flex-end; align-items: center; padding: 20px;">
        <form action="{{ route('monitor') }}" method="GET" style="display: inline-flex; align-items: center; width: 400px;">
            <input type="text" name="nama" id="nama" placeholder="Input Nama" style="padding: 5px; margin-right: 10px; width: 300px;">
            <button type="submit" style="padding: 5px 10px; cursor: pointer; width: 80px;">Cari</button>
        </form>
    </div>
    <div style="">
    <table id="myTable" class="display" >
        <thead>
            <tr>
                <th>Nama</th>
                <th>Barang</th>
              
            </tr>
        </thead>
        <tbody>
        @foreach($test as $item)
                <tr>
                <td>{{  $item['nama']}}</td> 
                <td>{{  $item['barang'] }}</td> 
                   
                    
                </tr>
            @endforeach
          
        </tbody>
    </table>
</div>
    <!-- Link ke file JS DataTables dan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "searching": false  
            });
        });
    </script>

</body>
</html>
