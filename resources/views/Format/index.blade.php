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
        <span>Format</span>
    </div>
    <br>
    <div class="d-flex justify-content-left ml-3" style="gap: 10px;">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
    <i class="fa fa-plus"></i>
</button>
</div>
    <div class="card-body">
        <div id="Mandarin" class="tabcontent">
            <!-- Table and Buttons -->
            <table id="tableMandarin" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Format</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['_id'] }}</td>
                            <td>{{ $item['Format'] }}</td>
                            <td>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-id="{{ $item['_id'] }}" data-format="{{ $item['Format'] }}">
                                        <i class="fa fa-edit"></i>
                                        </button>
                            </td>
                            <td>
                            <form action="{{ route('deleteFormat', ['id' => $item['_id']]) }}" method="POST">
                            @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
        <i class="fa fa-trash"></i>
    </button>
</form>


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
                <h5 class="modal-title" id="editModalLabel">Edit Format</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="template" class="form-label">ID</label>
                        <input type="text" class="form-control" id="_id" name="id" readonly>
                        <label for="template" class="form-label">Format</label>
                        <input type="text" class="form-control" id="format" name="format" required>
                    
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for creating new template -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Insert Format</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('addFormat') }}" id="createForm">
                    @csrf
                    <div class="mb-3">
                        <label for="_id" class="form-label">ID</label>
                        <input type="text" class="form-control" name="id" required>
                        <label for="format">Format</label>
                        <input type="text" class="form-control"  name="format" required>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
                <div>
                    <br>
                <table>
    <tr>
        <td style="vertical-align: top; font-size:14px">
            <strong>Form ID:</strong> <br>Isi Buy:kode produk jika produknya prabayar <br> jika produknya pascabayar <br> Isi Paybill: <br> kode produk dan untuk cek tagihan ppob di isi Viewbill:kode produk
        </td>
        <td style="vertical-align: top; font-size:14px">
            <strong>Form Format:</strong>  <br>
            {ProductCode} = KodeProduk <br>
            {Sequence} = counter di otomax (urutan transaksi) <br>
            {AccountNo} = nomor tujuan <br>
           {Amount} = nominal transfer (biasanya digunakan untuk produk transfer uang atau emoney)
           <br>
           {Pin} = pin transaksi
            
        </td>
    </tr>
</table>

                </div>
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
        searching: true, // Enable search
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
    // When the modal opens, populate the fields with the current values and set the correct form action
    var myModal = document.getElementById('editModal');
    myModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var id = button.getAttribute('data-id'); // Extract data-id attribute (the ID of the record)
        var format = button.getAttribute('data-format'); // Extract data-template attribute (current template value)
        // Set the form action to the correct route, including the ID
        var form = document.getElementById('editForm');
        form.action = '/editFormat' + id; // The correct route to update the record

        // Populate the input field with the current template value
        var idInput = document.getElementById('_id');
        var formatInput = document.getElementById('format');

        idInput.value = id; // Set the input field to the current template
        formatInput.value = format; // Set the input field to the current template

    });
</script>

@include('template/foot')
