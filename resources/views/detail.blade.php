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
            <div>
                <form action="{{ route('monitor') }}" method="GET" style="display: inline-flex; align-items: center; width: 400px;" class="search-form">
                    <input type="text" name="ProductCode" id="ProductCode" placeholder="Input Product Code" value="{{ request('ProductCode') }}">
                    <button type="submit">Cari</button>
                </form>
                <br><br>
            </div>

         
                <table id="tableMandarin" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>  
                            <th>Product Code</th>       
                            {{-- <th>Jumlah Transaksi</th>         
                            <th>Cashback</th>    
                            <th>Aksi</th>  --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($test as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['ProductCode'] }}</td>
                               
                                 
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
