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
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card card-primary">
    <div class="card-header">
        <span>Broad</span>
    </div>
<br>
    <div class="d-flex justify-content-left ml-3" style="gap: 10px;">
    <button class="btn btn-link" onclick="window.location.href='/broad'">Database</button>
    <button class="btn btn-success" onclick="window.location.href='/showfile'">CSV</button>
    <button class="btn btn-link" onclick="window.location.href='/Pesan'">Template Pesan</button>
</div>
    <br>
    <div class="d-flex justify-content-between m-3">
        <div>
        <form action="{{ route('fileKirim') }}" method="POST">
                @CSRF
        <button type="submit" class="btn btn-primary">Kirim Semua Pesan</button>
        </form>
     </div>
    <div class="d-flex flex-column align-content-center justify-content-center" style="gap: 10px;">
    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <input type="file" name="file" required />
    <button type="submit" class="btn btn-primary">Data Broad Cast</button>
    </form>

    <form action="{{ route('tempes') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required />
    <button type="submit" class="btn btn-primary">Template Pesan</button>
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
                        <th>No HP</th>
                        <th>Kirim Manual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_nama as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['kode'] }}</td>
                            <td>{{ $item['pengirim'] }}</td>
                            <td>
                        <form action="{{ route('fileManual', [$item['pengirim']]) }}" method="POST">
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
        order: [[1, 'asc']], // Order by column 'Kode' (first column) ascending
        info: true, // Show information about the number of rows
        language: {
            emptyTable: "Tidak ada data yang tersedia" // Message when no data is available
        }
    });
});
</script>

@include('template/foot')
