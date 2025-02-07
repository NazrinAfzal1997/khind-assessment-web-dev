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
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createStudentModalLabel">Create New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createStudentForm" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name">
                        <div id="firstNameError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name">
                        <div id="lastNameError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number">
                        <div id="contactNumberError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label for="registration_number" class="form-label">Student Registration Number</label>
                        <input type="text" class="form-control" id="registration_number" name="registration_number">
                        <div id="registrationNumberError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="program_id" class="form-label">Program</label>
                        <select class="form-control" id="program_id" name="program_id">
                            <option value="">Select a Program</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->code }} - {{ $program->name }}</option>
                            @endforeach
                        </select>
                        <div id="programError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="start_program_date" class="form-label">Start Program Date</label>
                        <input type="date" class="form-control" id="start_program_date" name="start_program_date">
                        <div id="startDateError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="end_program_date" class="form-label">End Program Date</label>
                        <input type="date" class="form-control" id="end_program_date" name="end_program_date">
                        <div id="endtDateError" class="text-danger text-sm" style="display: none;"></div>
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
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editStudentForm" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="studentId" name="id">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name-edit" name="first_name">
                        <div id="firstNameError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name-edit" name="last_name">
                        <div id="lastNameError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number-edit" name="contact_number">
                        <div id="contactNumberError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address-edit" name="address" rows="3"></textarea>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label for="registration_number" class="form-label">Student Registration Number</label>
                        <input type="text" class="form-control" id="registration_number-edit" name="registration_number">
                        <div id="registrationNumberError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="program_id" class="form-label">Program</label>
                        <select class="form-control" id="program_id-edit" name="program_id">
                            <option value="">Select a Program</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->code }} - {{ $program->name }}</option>
                            @endforeach
                        </select>
                        <div id="programError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="start_program_date" class="form-label">Start Program Date</label>
                        <input type="date" class="form-control" id="start_program_date-edit" name="start_program_date">
                        <div id="startDateError" class="text-danger text-sm" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="end_program_date" class="form-label">End Program Date</label>
                        <input type="date" class="form-control" id="end_program_date-edit" name="end_program_date">
                        <div id="endtDateError" class="text-danger text-sm" style="display: none;"></div>
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
                    $("#firstNameError").hide().text('');
                    $("#lastNameError").hide().text('');
                    $("#contactNumberError").hide().text('');
                    $("#registrationNumberError").hide().text('');
                    $("#programError").hide().text('');
                    $("#startDateError").hide().text('');
                    $("#endtDateError").hide().text('');
                    $("#createStudentForm")[0].reset();
                    $("#createStudentModal").modal('show');
                });

                $("#createStudentForm").submit(function(event) {
                    event.preventDefault();

                    $("#submitBtn").prop('disabled', true);
                    var formData = $(this).serialize();

                    $("#firstNameError").hide().text('');
                    $("#lastNameError").hide().text('');
                    $("#contactNumberError").hide().text('');
                    $("#registrationNumberError").hide().text('');
                    $("#programError").hide().text('');
                    $("#startDateError").hide().text('');
                    $("#endtDateError").hide().text('');

                    $.ajax({
                        url: 'student-management/store',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                var index = $('#data-table tbody tr').length + 1;

                                var newRow = `<tr>
                                    <td class="text-center align-middle text-sm">
                                        <p class="text-sm font-weight-bold mb-0">${index}</p>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <p class="text-sm font-weight-bold mb-0">${response.data.first_name}</p>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <p class="text-sm font-weight-bold mb-0">${response.data.last_name}</p>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <p class="text-sm font-weight-bold mb-0">${response.data.program ? response.data.program.code + ' - '  + response.data.program.name : 'N/A'}</p>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <p class="text-sm font-weight-bold mb-0">${new Date(response.data.start_program_date).toLocaleDateString()}</p>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <p class="text-sm font-weight-bold mb-0">${new Date(response.data.end_program_date).toLocaleDateString()}</p>
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
                                    'Student has been created.',
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
                            if (errors.first_name) {
                                $("#firstNameError").text(errors.first_name[0]).show();
                            }
                            if (errors.last_name) {
                                $("#lastNameError").text(errors.last_name[0]).show();
                            }
                            if (errors.contact_number) {
                                $("#contactNumberError").text(errors.contact_number[0]).show();
                            }
                            if (errors.registration_number) {
                                $("#registrationNumberError").text(errors.registration_number[0]).show();
                            }
                            if (errors.program_id) {
                                $("#programError").text(errors.program_id[0]).show();
                            }
                            if (errors.start_program_date) {
                                $("#startDateError").text(errors.start_program_date[0]).show();
                            }
                            if (errors.end_program_date) {
                                $("#endtDateError").text(errors.end_program_date[0]).show();
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
                    $('#first_name-edit').val(response.data.first_name);
                    $('#last_name-edit').val(response.data.last_name);
                    $('#contact_number-edit').val(response.data.contact_number);
                    $('#address-edit').val(response.data.address);
                    $('#registration_number-edit').val(response.data.registration_number);
                    $('#program_id-edit').val(response.data.program_id);
                    $('#start_program_date-edit').val(response.data.start_program_date);
                    $('#end_program_date-edit').val(response.data.end_program_date);

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
                url: 'student-management/' + id + '/update',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#editStudentModal').modal('hide');

                    var row = $('#data-table').find('button[data-id="' + response.data.id + '"]').closest('tr'); // Find existing row
                    var rowIndex = row.index() + 1;

                    row.html(`
                        <td class="text-center align-middle text-sm">
                            <p class="text-sm font-weight-bold mb-0">${rowIndex}</p> <!-- Preserve index -->
                        </td>
                        <td class="align-middle text-sm">
                            <p class="text-sm font-weight-bold mb-0">${response.data.first_name}</p>
                        </td>
                        <td class="align-middle text-sm">
                            <p class="text-sm font-weight-bold mb-0">${response.data.last_name}</p>
                        </td>
                        <td class="align-middle text-sm">
                            <p class="text-sm font-weight-bold mb-0">${response.data.program ? response.data.program.code + ' - '  + response.data.program.name : 'N/A'}</p>
                        </td>
                        <td class="align-middle text-sm">
                            <p class="text-sm font-weight-bold mb-0">${new Date(response.data.start_program_date).toLocaleDateString()}</p>
                        </td>
                        <td class="align-middle text-sm">
                            <p class="text-sm font-weight-bold mb-0">${new Date(response.data.end_program_date).toLocaleDateString()}</p>
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
                    `);

                    // var updatedRow = `
                    //     <td class="text-center align-middle text-sm">
                    //         <p class="text-sm font-weight-bold mb-0">${index + 1}</p>
                    //     </td>
                    //     <td class="align-middle text-sm">
                    //         <p class="text-sm font-weight-bold mb-0">${response.data.first_name}</p>
                    //     </td>
                    //     <td class="align-middle text-sm">
                    //         <p class="text-sm font-weight-bold mb-0">${response.data.last_name}</p>
                    //     </td>
                    //     <td class="align-middle text-sm">
                    //         <p class="text-sm font-weight-bold mb-0">${response.data.program ? response.data.program.code + ' - '  + response.data.program.name : 'N/A'}</p>
                    //     </td>
                    //     <td class="align-middle text-sm">
                    //         <p class="text-sm font-weight-bold mb-0">${new Date(response.data.start_program_date).toLocaleDateString()}</p>
                    //     </td>
                    //     <td class="align-middle text-sm">
                    //         <p class="text-sm font-weight-bold mb-0">${new Date(response.data.end_program_date).toLocaleDateString()}</p>
                    //     </td>
                    //     <td class="align-middle">
                    //         <div class="d-flex gap-2 justify-content-center align-items-center">
                    //             <button type="button" class="btn btn-light btn-sm edit-btn" data-id="${response.data.id}">
                    //                 <i class="fas fa-pencil"></i>
                    //             </button>
                    //             <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="${response.data.id}">
                    //                 <i class="fas fa-trash"></i>
                    //             </button>
                    //         </div>
                    //     </td>
                    // `;

                    // $('#data-table').find('button[data-id="' + response.data.id + '"]').closest('tr').html(updatedRow);

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
                    if (errors.first_name) {
                        $("#firstNameError").text(errors.first_name[0]).show();
                    }
                    if (errors.last_name) {
                        $("#lastNameError").text(errors.last_name[0]).show();
                    }
                    if (errors.contact_number) {
                        $("#contactNumberError").text(errors.contact_number[0]).show();
                    }
                    if (errors.registration_number) {
                        $("#registrationNumberError").text(errors.registration_number[0]).show();
                    }
                    if (errors.program_id) {
                        $("#programError").text(errors.program_id[0]).show();
                    }
                    if (errors.start_program_date) {
                        $("#startDateError").text(errors.start_program_date[0]).show();
                    }
                    if (errors.end_program_date) {
                        $("#endtDateError").text(errors.end_program_date[0]).show();
                    }
                    $("#submitBtn").prop('disabled', false);
                }
            });
        });

    });
</script>
