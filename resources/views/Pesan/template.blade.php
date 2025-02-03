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
    <button class="btn btn-link" onclick="window.location.href='/Pesan'">Template Pesan</button>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
    Insert Pesan
</button>
</div>

<br>


    <div class="d-flex d-flex justify-content-between m-3 ml-3">
   
  <div class=" d-flex flex-column align-content-center justify-content-center ml-3" style="gap: 10px;">
  <form action="{{ route('addPesan') }}" class="d-flex" method="POST" style="width: 600px;">
    <input type="text" name="template"  class="form-control me-3"  style="width: 200px;">
    <input type="text" name="status"  class="form-control me-3"  values="2" style="width: 200px;">
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
                        <th>Pesan</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->template }}</td>
                            <td>
    @if($item->status == 1)
        <!-- Button to deactivate (Nonaktif) -->
        <form action="{{ route('aktivasiPesan', ['id' => $item->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Input for setting status to 2 (Nonaktif) -->
            <button type="submit" class="btn btn-success">Aktif</button>
        </form>
    @else
        <!-- Button to activate (Aktif) -->
        <form action="{{ route('aktivasiPesan', ['id' => $item->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Input for setting status to 1 (Aktif) -->
            <button type="submit" class="btn btn-warning">NonAktif</button>
        </form>
    @endif
</td>
<td>
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal"
                    data-id="{{ $item->id }}" data-template="{{ $item->template }}">
                Edit
            </button>
</td>
<td>
<form action="{{ route('deletePesan', ['id' => $item->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
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
                <h5 class="modal-title" id="editModalLabel">Edit Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="template" class="form-label">Template</label>
                        <input type="text" class="form-control" id="template" name="template" required>
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
                <h5 class="modal-title" id="createModalLabel">New Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('addPesan') }}" id="createForm">
                    @csrf
                    <div class="mb-3">
                        <label for="template" class="form-label">Template</label>
                        <input type="text" class="form-control" id="template" name="template" required>
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
<script>
    // When the modal opens, populate the fields with the current values and set the correct form action
    var myModal = document.getElementById('editModal');
    myModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var id = button.getAttribute('data-id'); // Extract data-id attribute (the ID of the record)
        var template = button.getAttribute('data-template'); // Extract data-template attribute (current template value)
        
        // Set the form action to the correct route, including the ID
        var form = document.getElementById('editForm');
        form.action = '/editPesan' + id; // The correct route to update the record

        // Populate the input field with the current template value
        var templateInput = document.getElementById('template');
        templateInput.value = template; // Set the input field to the current template
    });
</script>

@include('template/foot')
