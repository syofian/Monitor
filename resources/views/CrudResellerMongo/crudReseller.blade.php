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
        <span>Reseller Mongo</span>
    </div>
    <br>

   
<div class="d-flex justify-content-start ml-3">
  <form action="{{ route('ResellerMongo') }}" class="d-flex" method="GET" style="width: 600px;">
    <input type="text" name="Kode"  class="form-control me-3"  style="width: 200px;">
    <button type="submit" class="btn btn-primary">Cari</button>
</form>

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
                        <th>Kota</th>
                        <th>Kode Level</th>
                        <th>Nomor HP</th>
                        <th>Pin</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['Kode'] }}</td>
                            <td>{{ $item['Nama'] }}</td>
                            <td>{{ $item['Kota'] }}</td>
                            <td>{{ $item['KodeLevel'] }}</td>
                            <td>{{ $item['NoHPPrimary'] }}</td>
                            <td id="pin-cell" onclick="togglePin(this, '{{ $item['Pin'] }}')">*****</td>                   
                            <td>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-id="{{ $item['Kode'] }}" data-pin="{{ $item['Pin'] }}" >
                                            <i class="fa fa-edit"></i>
                                        </button>
                            </td>


                                        </tr>
                    @endforeach
                </tbody>
            </table>

         
        </div>
    </div>
</div>
<!-- Modal for editing the template -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Pin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="template" class="form-label">Pin</label>
                        <input type="text" class="form-control" id="pin" name="Pin" required>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Include Bootstrap CSS -->

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#tableMandarin').DataTable({
        paging: true, // Enable pagination
        searching: false, // Enable search
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]], // Rows per page options
        order: [[0, 'asc']], // Order by column 'No' (second column) ascending
        info: true, // Show information about the number of rows
        language: {
            emptyTable: "Tidak ada data yang tersedia"
        }
    });

    
});

</script>
<script>
   function togglePin(tdElement, pinValue) {
    // Check if the cell already displays the Pin value
    if (tdElement.textContent === pinValue) {
        // If it does, hide the Pin value by changing the text back to asterisks
        tdElement.textContent = "*****";
    } else {
        // If it doesn't, show the Pin value
        tdElement.textContent = pinValue;
    }
}

</script>


@include('template/foot')
