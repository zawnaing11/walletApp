@extends('frontend.layouts.app')
@section('title', 'Transfer Confirmation')
@section('content')
    <div class="transfer">
        <div class="card transfer-card">
            <div class="card-body">
                @error('error')
                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                @enderror
                <form action="{{ route('transfer.complete') }}" method="POST" id="form">
                    @csrf
                    <input type="hidden" name="phone" value="{{ $receiver->phone }}">
                    <input type="hidden" name="amount" value="{{ $data['amount'] }}">
                    <input type="hidden" name="description" value="{{ $data['description'] }}">
                    <div class="form-group">
                        <label for="">From</label>
                        <p class="mb-1 text-muted">{{ auth()->user()->name }}</p>
                        <p class="mb-1 text-muted">{{ auth()->user()->phone }}</p>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="mb-0"><strong>To</strong></label>
                        <p class="mb-1 text-muted">{{ $receiver['name'] }}</p>
                        <p class="text-muted">{{ $receiver['phone'] }}</p>
                    </div>
                    <div class="form-group">
                    <label for="amount" class="mb-0"><strong>Amount (MMK)</strong></label>
                        <p class="text-muted">{{ number_format($data['amount']) }}</p>
                    </div>
                    <div class="form-group">
                    <label for="description" class="mb-0"><strong>Description</strong></label>
                        <p class="text-muted">{{ $data['description'] }}</p>
                    </div>
                    <input type="submit" class="btn btn-theme btn-block mt-5 confirm-btn" value="Confirm">
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $('.confirm-btn').on('click', function (e) {
            e.preventDefault();
            Swal.fire({
              title: '<strong>Please Fill Your Password!</strong>',
              icon: 'info',
              html: '<input type="password" class="form-control text-center password">',
              showCloseButton: true,
              showCancelButton: true,
              confirmButtonText:'<strong>Confirm</strong>',
              cancelButtonText:'<strong>Cancle</strong>',
              reverseButtons: true
            }).then((result) => {
              if (result.isConfirmed) {
                  var password = $('.password').val();
                $.ajax({
                    url: '/password-check?password=' + password,
                    type: 'GET',
                    success: function(res) {
                        if (res.status) {
                            $('#form').submit();
                        } else {
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: res.message
                            })
                        }
                    }
                })
              }
            })
        });
    });
</script>
@endsection
