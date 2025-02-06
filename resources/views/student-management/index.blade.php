@extends('layouts.app', ['title' => 'Student Management'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Student Management'])
    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'Great!'
            });
        </script>
    @endif
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>Student Management</h6>
                    <button id="createStudentButton" type="button" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp; Add Student</button>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0 mt-3">
                        <table id="data-table" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-xs font-weight-bolder">#</th>
                                    <th class="text-uppercase text-xs font-weight-bolder">First Name</th>
                                    <th class="text-uppercase text-xs font-weight-bolder">Last Name</th>
                                    <th class="text-uppercase text-xs font-weight-bolder">Program</th>
                                    <th class="text-uppercase text-xs font-weight-bolder">Date Start</th>
                                    <th class="text-uppercase text-xs font-weight-bolder">Date End</th>
                                    <th class="text-center text-uppercase text-xs font-weight-bolder">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="modal fade" id="createStudentModal" tabindex="-1" aria-labelledby="createStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createStudentModalLabel">Create New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createStudentForm" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="code" name="code">
                        <div id="codeError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <div id="nameError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="submitBtn">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Modal Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editStudentForm" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="studentId" name="id">
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="code-edit" name="code">
                        <div id="codeError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name-edit" name="name">
                        <div id="nameError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description-edit" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="submitBtn">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {

        $.ajax({
            url: '/student-management/fetch-data',
            method: 'GET',
            success: function(response) {
                let rows = '';
                $.each(response, function(index, item) {
                    rows += `'<tr>
                                <td class="text-center align-middle text-sm">
                                    <p class="text-sm font-weight-bold mb-0">${index + 1}</p>
                                </td>
                                <td class="align-middle text-sm">
                                    <p class="text-sm font-weight-bold mb-0">${item.first_name}</p>
                                </td>
                                <td class="align-middle text-sm">
                                    <p class="text-sm font-weight-bold mb-0">${item.last_name}</p>
                                </td>
                                <td class="align-middle text-sm">
                                    <p class="text-sm font-weight-bold mb-0">${item.program ? item.program.code + ' - '  + item.program.name : 'N/A'}</p>
                                </td>
                                <td class="align-middle text-sm">
                                    <p class="text-sm font-weight-bold mb-0">${new Date(item.start_program_date).toLocaleDateString()}</p>
                                </td>
                                <td class="align-middle text-sm">
                                    <p class="text-sm font-weight-bold mb-0">${new Date(item.end_program_date).toLocaleDateString()}</p>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex gap-2 justify-content-center align-items-center">
                                        <button type="button" class="btn btn-light btn-sm edit-btn" data-id="${item.id}"><i class="fas fa-pencil"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>'`;
                });

                $('#data-table tbody').html(rows);

                $('#createStudentButton').click(function() {
                    $("#codeError").hide().text('');
                    $("#nameError").hide().text('');
                    $("#createStudentForm")[0].reset();
                    $("#createStudentModal").modal('show');
                });

                $("#createStudentForm").submit(function(event) {
                    event.preventDefault();

                    $("#submitBtn").prop('disabled', true);
                    var formData = $(this).serialize();

                    $("#codeError").hide().text('');
                    $("#nameError").hide().text('');

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                var newRow = `<tr>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">${response.data.code}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">${response.data.name}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">${response.data.name}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">${new Date(response.data.created_at).toLocaleDateString()}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">${new Date(response.data.updated_at).toLocaleDateString()}</p>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex gap-2 justify-content-center align-items-center">
                                            <button type="button" class="btn btn-light btn-sm edit-btn" data-id="${response.data.id}">
                                                <i class="fas fa-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="${response.data.id}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>`;

                                $('#data-table tbody').append(newRow);

                                $("#createStudentModal").modal('hide');
                                $("#successMessage").text(response.message).show();
                                $("#submitBtn").prop('disabled', false);

                                Swal.fire(
                                    'Created!',
                                    'Your item has been created.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Something went wrong. Please try again.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.code) {
                                $("#codeError").text(errors.code[0]).show();
                            }
                            if (errors.name) {
                                $("#nameError").text(errors.name[0]).show();
                            }
                            $("#submitBtn").prop('disabled', false);
                        }
                    });
                });
            },
            error: function() {
                alert('Error fetching data.');
            }
        });

        $('#data-table').on('click', '.delete-btn', function() {
            var id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/student-management/destroy/' + id,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if (response.success) {
                                $('button[data-id="' + id + '"]').closest('tr').remove();

                                Swal.fire(
                                    'Deleted!',
                                    'Your item has been deleted.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Something went wrong. Please try again.',
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the item.',
                                'error'
                            );
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        'Your item is safe!',
                        'info'
                    );
                }
            });
        });


        $('#data-table').on('click', '.edit-btn', function() {
            var id = $(this).data('id');

            $.ajax({
                url: '/student-management/edit/' + id,
                method: 'GET',
                success: function(response) {
                    $('#studentId').val(response.data.id);
                    $('#code-edit').val(response.data.code);
                    $('#name-edit').val(response.data.name);
                    $('#description-edit').val(response.data.description);

                    $('#editStudentModal').modal('show');
                }
            });
        });

        $('#editStudentForm').submit(function(event) {
            event.preventDefault();
            var id = $('#studentId').val();
            var form = $(this);
            var formData = form.serialize();

            $.ajax({
                url: 'student/' + id + '/update',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#editStudentModal').modal('hide');

                    var updatedRow = `
                        <td class="align-middle text-center text-sm">
                            <p class="text-sm font-weight-bold mb-0">${response.data.code}</p>
                        </td>
                        <td>
                            <p class="text-sm font-weight-bold mb-0">${response.data.name}</p>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <p class="text-sm font-weight-bold mb-0">${new Date(response.data.created_at).toLocaleDateString()}</p>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <p class="text-sm font-weight-bold mb-0">${new Date(response.data.updated_at).toLocaleDateString()}</p>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex gap-2 justify-content-center align-items-center">
                                <button type="button" class="btn btn-light btn-sm edit-btn" data-id="${response.data.id}">
                                    <i class="fas fa-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="${response.data.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    `;

                    $('#data-table').find('button[data-id="' + response.data.id + '"]').closest('tr').html(updatedRow);

                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Student successfully updated",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.code) {
                        $("#codeError").text(errors.code[0]).show();
                    }
                    if (errors.name) {
                        $("#nameError").text(errors.name[0]).show();
                    }
                    $("#submitBtn").prop('disabled', false);
                }
            });
        });

    });
</script>
