@include('template/head')

<style type="text/css">
    .card {
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
    }

    .card-header {
        padding: 10px;
        background-color: #f0f0f0;
        border-bottom: 1px solid #ccc;
    }

    .card-body {
        flex-grow: 1;
        overflow: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        border: 1px solid #ccc;
        padding: 8px;
    }

    /* Styling the form */
    .search-form input[type="text"] {
        padding: 5px;
        margin-right: 10px;
        width: 300px;
    }

    .search-form button {
        padding: 5px 10px;
        width: 80px;
        cursor: pointer;
    }
</style>

<div class="card card-primary">
    <div class="card-header">
        <span>Monitor</span>
    </div>
    
    <div class="card-body">
        <div id="Mandarin" class="tabcontent">
            <div class="d-flex justify-content-center">
                <form action="{{ route('monitor') }}" method="GET" class="d-flex gap-3 align-items-center" style="width: 600px;">
                    <!-- Input Product Code (Lebar disesuaikan) -->
                    <input type="text" name="ProductCode" id="ProductCode" value="{{ request('ProductCode') }}" class="form-control" style="width: 200px;">
                    
                    <!-- Input Tanggal -->
                    <input type="date" name="date1" value="{{ request('date1') }}" class="form-control">
                    <input type="date" name="date2" value="{{ request('date2') }}" class="form-control">
                    
                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
            </div>
            
         
                <table id="tableMandarin" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>  
                            <th>Product Code</th>       
                            <th>Jumlah Transaksi</th>         
                            <th>Cashback</th>    
                            <th>Aksi</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['_id'] }}</td>
                                <td>{{ $item['total_count'] }}</td>
                                <td>{{ $item['total_cashback'] }}</td>
                                <td>
                                  <a href="/voucher.{{ $item['_id'] }}" class="btn-cekmonitor">
                                    Detail
                                </a>
                                 
                              </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
           
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#tableMandarin').DataTable({
            paging: true, // Aktifkan paging (paginasi)
            searching: true, // Menonaktifkan fitur pencarian
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]], // Opsi jumlah baris
            order: [[0, 'asc']], // Urutkan berdasarkan kolom pertama secara ascending
            info: true, // Menampilkan informasi jumlah data
            language: {
                emptyTable: "Tidak ada data yang tersedia"
            }
        });
    });
</script>

@include('template/foot')
