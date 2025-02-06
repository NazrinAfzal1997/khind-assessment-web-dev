@extends('layouts.app', ['title' => 'Programs'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Programs'])
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
                <div class="card-header pb-0">
                    <h6>Programs</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0 mt-3">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-xs font-weight-bolder">Program Code</th>
                                    <th class="text-center text-uppercase text-xs font-weight-bolder">Program Name</th>
                                    <th class="text-center text-uppercase text-xs font-weight-bolder">Created Date</th>
                                    <th class="text-center text-uppercase text-xs font-weight-bolder">Updated Date</th>
                                    <th class="text-center text-uppercase text-xs font-weight-bolder">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($programs->isEmpty())
                                    <tr>
                                        <td colspan="5">
                                            <p class="text-sm font-weight-bold mb-0">No Data</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($programs as $index => $program)
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $program->code }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $program->name }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $program->created_at->format('d/m/Y') }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $program->updated_at->format('d/m/Y') }}</p>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex gap-2 justify-content-center align-items-center">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-pencil"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $program->id }}"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>

                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Attach click event to delete buttons
        $('.delete-btn').on('click', function () {
            var itemId = $(this).data('id');
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form and submit it using jQuery
                    var form = $('<form>', {
                        method: 'POST',
                        action: '/program/destroy/' + itemId
                    });

                    // Add CSRF token and DELETE method to the form
                    form.append('@csrf');
                    form.append('<input type="hidden" name="_method" value="DELETE">');
                    $('body').append(form);
                    form.submit();
                }
            });
        });
    });
</script>
