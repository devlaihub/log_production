<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Production Log</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Bootstrap CSS for Modal -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome CDN for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap JS for Modal -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Link to the external CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <div class="container">
        <h1>Production Log</h1>
        <hr>    

    <!-- User Information Box -->
    <div class="card">
        <div class="card-header">
            <strong>User Information</strong>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
            <p><strong>ID Card:</strong> {{ Auth::user()->id_card }}</p>
            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>
    </div>
    <br>
        <!-- Button to trigger Add modal -->
        <div class="btn-container">
            <button class="btn btn-primary" data-toggle="modal" data-target="#productionLogModalAdd">
                <i class="fas fa-plus"></i> Add Production Log
            </button>
        </div>

        <!-- DataTable -->
        <table id="productionLogTable" class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Product Type</th>
                    <th>Total Good Product (Kg) </th>
                    <th>Total Defect (Kg) </th>
                    <th>User</th>
                    <th>Actions</th> <!-- Added column for Edit -->
                </tr>
            </thead>
            <tbody>
                <!-- DataTable will be filled dynamically -->
            </tbody>
        </table>
    </div>

    <!-- Modal for Add Production Log -->
    <div class="modal fade" id="productionLogModalAdd" tabindex="-1" role="dialog" aria-labelledby="productionLogModalLabelAdd" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productionLogModalLabelAdd">Add Production Log</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="productionLogFormAdd" action="/production-log" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Date Input -->
                        <div class="form-group">
                            <label for="date">Date:</label>
                            <input type="datetime-local" name="date" class="form-control" id="date" required>
                        </div>

                        <!-- Product Type Input -->
                        <div class="form-group">
                            <label for="product_type">Product Type:</label>
                            <select name="product_type" class="form-control" required>
                                <option value="PACA">PACA</option>
                                <option value="PACS">PACS</option>
                                <option value="PACV">PACV</option>
                                <option value="PACA_EXPORT">PACA_EXPORT</option>
                            </select>
                        </div>

                        <!-- Total Good Product Input -->
                        <div class="form-group">
                            <label for="total_good_product">Total Good Product (Kg) :</label>
                            <input type="number" name="total_good_product" class="form-control" required>
                        </div>

                        <!-- Total Defect Input -->
                        <div class="form-group">
                            <label for="total_defect">Total Defect (Kg) :</label>
                            <input type="number" name="total_defect" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Production Log -->
    <div class="modal fade" id="productionLogModalEdit" tabindex="-1" role="dialog" aria-labelledby="productionLogModalLabelEdit" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productionLogModalLabelEdit">Edit Production Log</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="productionLogFormEdit" action="/production-log/update/{id}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="date_edit">Date:</label>
                            <input type="datetime-local" name="date" class="form-control" id="date_edit" required>
                        </div>

                        <div class="form-group">
                            <label for="product_type_edit">Product Type:</label>
                            <select name="product_type" class="form-control" id="product_type_edit" required>
                                <option value="PACA">PACA</option>
                                <option value="PACS">PACS</option>
                                <option value="PACV">PACV</option>
                                <option value="PACA_EXPORT">PACA_EXPORT</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="total_good_product_edit">Total Good Product (Kg) :</label>
                            <input type="number" name="total_good_product" class="form-control" id="total_good_product_edit" required>
                        </div>

                        <div class="form-group">
                            <label for="total_defect_edit">Total Defect (Kg) :</label>
                            <input type="number" name="total_defect" class="form-control" id="total_defect_edit" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        // Set the current date and time in the modal form's date input for Add
        $('#productionLogModalAdd').on('shown.bs.modal', function () {
            var currentDate = new Date();
            var localDateString = currentDate.toLocaleString('sv-SE').slice(0, 16);
            $('#date').val(localDateString);
        });

        // Initialize DataTable with AJAX
        $(document).ready(function() {
            var table = $('#productionLogTable').DataTable({
                serverSide: false,
                ajax: {
                    url: '/production-log/data',  // URL untuk mengambil data
                    type: 'GET',
                },
                columns: [
                    { data: 'date' },
                    { data: 'product_type' },
                    { data: 'good_product' },
                    { data: 'total_defect' },
                    { data: 'user_name' },
                    { 
                        data: null, 
                        defaultContent: '<button class="btn btn-warning btn-sm edit-btn">Edit</button>' // Add Edit button
                    },
                ],
                order: [[0, 'desc']],
                responsive: true,
                scrolX: true,
                processing: true,  // Enable loading indicator
            });

            // Open modal with the data of the clicked row for editing
            $('#productionLogTable').on('click', '.edit-btn', function() {
                var data = table.row($(this).closest('tr')).data();
                
                // Set the modal label and form action to the correct URL
                $('#productionLogModalLabelEdit').text('Edit Production Log');
                $('#date_edit').val(data.date);
                $('#product_type_edit').val(data.product_type);
                $('#total_good_product_edit').val(data.good_product);
                $('#total_defect_edit').val(data.total_defect);

                // Set the form action to the correct update URL including the ID
                $('#productionLogFormEdit').attr('action', '/production-log/update/' + data.id); 
                
                // Open the Edit modal
                $('#productionLogModalEdit').modal('show');
            });
        });

        // Handle form submit and validation with SweetAlert for Add and Edit
        $('#productionLogFormAdd, #productionLogFormEdit').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var formAction = form.attr('action');
            
            // Cek ID input sesuai dengan ID pada modal
            var dateField = form.find('#date, #date_edit'); // Untuk modal Add dan Edit
            var productTypeField = form.find('select[name="product_type"]');
            var totalGoodProductField = form.find('input[name="total_good_product"]');
            var totalDefectField = form.find('input[name="total_defect"]');

            if (dateField.val() && productTypeField.val() && totalGoodProductField.val() && totalDefectField.val()) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to submit this data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Submit it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: formAction,
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: form.serialize(),
                            success: function(response) {
                                if(response.status == 'success') {
                                    Swal.fire('Success!', response.message, 'success');
                                    $('#productionLogModalAdd, #productionLogModalEdit').modal('hide');
                                    
                                    // Reload DataTable
                                    $('#productionLogTable').DataTable().ajax.reload();
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error!', 'An error occurred while submitting the form. Please try again.', 'error');
                            }
                        });
                    }
                });
            } else {
                Swal.fire('Error!', 'Please fill in all fields before submitting.', 'error');
            }
            
            // Reset modal form inputs after modal is hidden
            $('#productionLogModalAdd').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset(); // Reset all inputs in the form
            });
        });

    </script>

    <!-- auto logout close tab -->
    <script>
        window.addEventListener('beforeunload', function(event) {
            // Mengirim permintaan POST untuk logout jika tab akan ditutup
            fetch('/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ logout: true })
            });
        });
    </script>

</body>
</html>
