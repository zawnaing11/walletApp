@extends('frontend.layouts.app')
@section('title', $status == 1 ? 'Transaction Completed' : 'Transaction Detail')
@section('content')
    <div class="transaction-detail">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    @if ($status == 2)
                        <img src="{{ asset('frontend/images/transactions.png') }}" alt="">
                    @else
                        <img src="{{ asset('frontend/images/checked.png') }}" alt="">
                    @endif
                    <p class="text-center mt-3 mb-1">{{ $status == 1 ? 'Completed' : 'History' }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-1">Reference No</p>
                    <p class="mb-1">{{ $transaction->ref_no }}</p>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <p class="mb-1">Type</p>
                    <p class="mb-1">
                        @if ($transaction->type == 1)
                            <span class="badge badge-success">Income</span>
                        @else
                            <span class="badge badge-danger">Expense</span>
                        @endif
                    </p>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <p class="mb-1">{{ $transaction->type == 1 ? 'From' : 'To' }}</p>
                    <p class="mb-1">{{ $transaction->receiverUser ? $transaction->receiverUser->name : '' }}</p>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <p class="mb-1">Amount</p>
                    <p class="mb-1 @if($transaction->type == 1) text-success @else text-danger @endif"><span class="font-weight-bold">{{ $transaction->amount }}</span> <small>MMK</small></p>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <p class="mb-1">Descrition</p>
                    <p class="mb-1">{{ $transaction->description }} </p>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <p class="mb-1">Date & Time</p>
                    <p class="mb-1">{{ $transaction->created_at }} </p>
                </div>
            </div>
        </div>
    </div>
@endsection
