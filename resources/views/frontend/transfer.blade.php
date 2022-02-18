@extends('frontend.layouts.app')
@section('title', 'Transfer')
@section('content')
    <div class="transfer">
        <div class="card transfer-card">
            <div class="card-body">
                <form action="{{ route('transfer.confirm') }}" method="GET" id="transfer-form">
                    <input type="hidden" name="hash" value="">
                    <div class="form-group">
                        <label for="">From</label>
                        <p class="mb-1 text-muted">{{ auth()->user()->name }}</p>
                        <p class="mb-1 text-muted">{{ auth()->user()->phone }}</p>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <div class="input-group">
                            <input type="number" class="form-control phone @error('phone') is-invalid @enderror" placeholder="phone" name="phone" value="{{ old('phone') }}">
                            <div class="input-group-append">
                                <span class="input-group-text verify-btn" id="exampleAddon"><i class="fas fa-user-check"></i></span>
                            </div>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control account_name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount (MMK)</label>
                        <input type="text" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}">
                        @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" value="">{{ old('description') }}</textarea>
                    </div>
                    <input type="button" class="btn btn-theme btn-block mt-5 submit-btn" value="continue">
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('.verify-btn').on('click', function() {
            var phone = $('.phone').val();
            $.ajax({
                url: '/to-account-verify?phone=' + phone,
                type: 'GET',
                success: function(res) {
                    if (res.status) {
                        console.log(res);
                        $('#exampleAddon').attr('style', 'color:#28a745');
                        $('.account_name').val(res.data.name).attr('style', 'color:#28a745');
                    } else {
                        $('#exampleAddon').attr('style', 'color:#495057');
                        $('.account_name').val('').attr('style', 'color:#28a745');
                    }
                }
            })
        });
        // hashing data
        $('.submit-btn').on('click', function(e) {
            e.preventDefault();
            var phone = $("input[name=phone]").val();
            var amount = $("input[name=amount]").val();
            var description = $("input[name=description]").val();
            $.ajax({
                url: `/transfer-hash?phone=${phone}&amount=${amount}&description=${description}`,
                type: 'GET',
                success: function(res) {
                    if (res.status) {
                        console.log(res);
                        $('input[name=hash]').val(res.data);
                        $('#transfer-form').submit();
                    }
                }
            })

        });
    });
</script>
@endsection
