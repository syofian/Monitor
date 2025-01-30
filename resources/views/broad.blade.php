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

    #select-all {
        cursor: pointer;
    }
</style>

<div class="card card-primary">
    <div class="card-header">
        <span>Broad</span>
    </div>
    <br>

    <div class="d-flex justify-content-left ml-3" style="gap: 10px;">
    <button class="btn btn-success" onclick="window.location.href='/broad'">Database</button>
    <button class="btn btn-link" onclick="window.location.href='/showfile'">CSV</button>
    <button class="btn btn-link" onclick="window.location.href='/template_pesan'">Template Pesan</button>

</div>

<br>

    <div class="d-flex justify-content-left ml-3">
    <form action="{{ route('kirim', [
    'awal' => request()->has('awal') ? request()->input('awal') : '#', 
    'akhir' => request()->has('akhir') ? request()->input('akhir') : '#'
]) }}" method="POST">
    @csrf <!-- Jangan lupa untuk menambahkan CSRF token -->
    <button type="submit" class="btn btn-primary">Kirim Semua Pesan</button>
  </form>
  <div class="ml-3">
  <form action="{{ route('broad') }}" class="d-flex" method="GET" style="width: 600px;">
    <input type="text" name="awal" value="{{ request('awal') }}" class="form-control me-3" placeholder="Dari Data Ke" style="width: 200px;">
    <input type="text" name="akhir" value="{{ request('akhir') }}" class="form-control me-3" placeholder="Jumlah Data" style="width: 200px;">
    <button type="submit" class="btn btn-primary">Cari</button>
</form>


            </div>
</div>

    <div class="card-body">
        <div id="Mandarin" class="tabcontent">
            <!-- Table and Buttons -->
            <table id="tableMandarin" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>No Tlp</th>
                        <th>Kirim Manual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kode_reseller }}</td>
                            <td>{{ $item->pengirim }}</td>
                        <td>
                        <form action="{{ route('selfKirim', ['pengirim' => $item->pengirim]) }}" method="POST">
    @csrf <!-- This directive is necessary for CSRF protection in Laravel -->
    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
</form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

         
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#tableMandarin').DataTable({
        paging: true, // Enable pagination
        searching: true, // Enable search
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]], // Rows per page options
        order: [[1, 'asc']], // Order by column 'No' (second column) ascending
        info: true, // Show information about the number of rows
        language: {
            emptyTable: "Tidak ada data yang tersedia"
        }
    });

    
});

</script>
@include('template/foot')
