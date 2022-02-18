@extends('backend.layouts.app')
@section('title', 'Users')
@section('user-active', 'mm-active')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit"></i>
            </div>
            <div>User Dashboard</div>
        </div>
    </div>
</div>
<div class="pt-3">
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Create User</a>
</div>
<div class="content pt-3">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered Datatable">
                <thead>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>IP</th>
                    <th class="no-sort">User Agent</th>
                    <th class="no-sort">Created At</th>
                    <th>Updated At</th>
                    <th class="no-sort">Action</th>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        var dataTable = $('.Datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin.user.datatables.ssd') !!}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'ip', name: 'ip' },
                { data: 'user_agent', name: 'user_agent' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action' }
            ],
            order: [[ 6, 'desc' ]],
            columnDefs: [{
                targets: 'no-sort',
                searchable: false,
                sortable: false
            }]
        });
        $(document).on('click', '.delete-icon', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: 'Do you want to delete this user?',
                showCancelButton: true,
                confirmButtonText: `Delete`
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/user/' + id,
                        type: 'DELETE',
                        success: function() {
                            dataTable.ajax.reload();
                        }
                    });
                }
            })
        });
    } );
</script>
@endsection