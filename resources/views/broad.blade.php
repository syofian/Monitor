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
    <div class="d-flex justify-content-left ml-3">
    <form action="{{ route('kirim', [
    'startDate' => request()->has('date1') ? request()->input('date1') : '#', 
    'endDate' => request()->has('date2') ? request()->input('date2') : '#'
]) }}" method="POST">
    @csrf <!-- Jangan lupa untuk menambahkan CSRF token -->
    <button type="submit" class="btn btn-primary">Kirim Semua Pesan</button>
  </form>
  <div class="d-flex justify-content-center ml-3 gap-2">
                <form action="{{ route('broad') }}" method="GET" class="d-flex gap-3 align-items-center" style="width: 600px;">
                    <!-- Input Product Code (Lebar disesuaikan) -->
                    <input type="date" name="date1"  value="{{ request('date1') }}" class="form-control" style="width: 200px;">
                    <input type="date" name="date2"  value="{{ request('date2') }}" class="form-control" style="width: 200px;">


                    <!-- Tombol Submit -->
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
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No Tlp</th>
                        <th>Kirim Manual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->pengirim }}</td>
                        <td>
                        <form action="{{ route('selfKirim', ['kode' => $item->pengirim]) }}" method="POST">
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
