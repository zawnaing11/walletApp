@extends('frontend.layouts.app')
@section('title', 'Transaction')
@section('content')
<div class="transaction">
    <h6 class="mb-2"><i class="fa fa-filter"></i> Filter</h6>
    <div class="card mb-2">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-6">
                    <div class="input-group my-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Date</label>
                        </div>
                        <input type="text" class="date form-control" value="{{ request()->date ?? date('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group my-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Type</label>
                        </div>
                        <select class="custom-select type">
                            <option value="">All</option>
                            <option value="1" @if(request()->type == 1) selected @endif>Income</option>
                            <option value="2" @if(request()->type == 2) selected @endif>Expense</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h6 class="my-2"> Transaction</h6>
    <div class="infinite-scroll">
        @foreach ($transactions as $transaction)
        <a href="{{ route('transaction.detail', ['trs_id' => $transaction->trs_id, 'status' => 2]) }}">
            <div class="card mb-2">
                <div class="crad-body p-2">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-1 text-muted">
                            {{ $transaction->type == 1 ? 'From' : 'To' }}
                            {{ $transaction->receiverUser ? $transaction->receiverUser->name : '' }}
                        </h6>
                        <h6 class="mb-1 @if($transaction->type == 1)text-success @else text-danger @endif">{{ $transaction->amount }} <small>MMK</small></h6>
                    </div>
                    <p class="mb-1 text-muted">
                        {{ $transaction->created_at }}
                    </p>
                </div>
            </div>
        </a>
        @endforeach
        {{ $transactions->links() }}
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $('ul.pagination').hide();
    $(function() {
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            loadingHtml: '<div class="text-center"><img src="{{ asset('frontend/images/loading.gif') }}" alt="Loading..." /></div>',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
        // Date
        $('.date').daterangepicker({
            "singleDatePicker": true,
            "autoApply": true,
            "locale": {
                "format": "YYYY-MM-DD",
            }
        });
        $('.date').on('apply.daterangepicker', function(ev, picker) {
            var date = $('.date').val();
            var value = $('.type').val();
            history.pushState(null, '', `?date=${date}&type=${value}`);
            window.location.reload();
        });
        // Type
        $('.type').on('change', function() {
            var date = $('.date').val();
            var value = $('.type').val();
            history.pushState(null, '', `?date=${date}&type=${value}`);
            window.location.reload();
        });
    });
</script>
@endsection
