@extends('backend.layouts.app')
@section('admin-user-active', 'mm-active')
@section('title', 'Edit Admin Users')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit"></i>
            </div>
            <div>Edit Admin User</div>
        </div>
    </div>
</div>
<div class="content pt-3">
    <div class="card">
        <div class="card-body">
            @include('backend.layouts.flash')
            <form action="{{ route('admin.admin-user.update', $admin_user->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $admin_user->name) }}">
                </div>
                <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $admin_user->email ) }}">
                </div>
                <div class="form-group">
                    <label for="Phone">Phone</label>
                    <input type="number" name="phone" class="form-control" id="phone" value="{{ old('phone', $admin_user->phone) }}">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" value="{{ old('password') }}">
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-secondary mr-2 back-btn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateAdminUserRequest') !!}
<script>
    $(document).ready(function() {

    });
</script>
@endsection