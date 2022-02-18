@extends('frontend.layouts.app')
@section('title', 'Wallet')
@section('content')
    <div class="wallet">
        <div class="card wallet-card">
            <div class="card-body">
                <div class="mb-4">
                    <span>Balance</span>
                    <h4>{{ number_format($currentUser->wallet ? $currentUser->wallet->amount : 0) }} <span>MMK</span></h4>
                </div>
                <div class="mb-4">
                    <span>Account Number</span>
                    <h4>{{ $currentUser->wallet ? $currentUser->wallet->account_number : '-' }}</h4>
                </div>
                <div class="mb-4">
                    <p>{{ $currentUser->name }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
