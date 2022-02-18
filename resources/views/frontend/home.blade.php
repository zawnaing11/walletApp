@extends('frontend.layouts.app')
@section('title', 'Wallet App')
@section('content')
    <div class="home">
        <div class="row">
            <div class="col-12">
                <div class="profile mb-3">
                    <img src="https://ui-avatars.com/api/?background=5842e3&color=fff&name={{ auth()->user()->name }}" alt="">
                    <h6>{{ auth()->user()->name }}</h6>
                    <p class="text-muted">{{ auth()->user()->wallet ? number_format(auth()->user()->wallet->amount) : 0 }} MMK</p>
                </div>
            </div>
            <div class="col-6">
                <div class="card scanpay-box">
                    <div class="card-body p-3">
                        <img src="{{ asset('frontend/images/qr-code-scan-128.png') }}" alt="">
                        <span>Scan & Pay</span>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card scanpay-box">
                    <div class="card-body p-3">
                        <img src="{{ asset('frontend/images/qr-code.png') }}" alt="">
                        <span>Receive QR</span>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="card mb-3 function-box">
                    <div class="card-body pr-0">
                        <a href="{{ route('transfer') }}" class="d-flex justify-content-between">
                            <span><img src="{{ asset('frontend/images/money-transfer.png') }}" alt=""> Transfer</span>
                            <span class="mr-3"><i class="fas fa-angle-right"></i></span>
                        </a>
                        <hr>
                        <a href="{{ route('wallet') }}" class="d-flex justify-content-between">
                            <span><img src="{{ asset('frontend/images/wallet.png') }}" alt=""> Wallet</span>
                            <span class="mr-3"><i class="fas fa-angle-right"></i></span>
                        </a>
                        <hr>
                        <a href="{{ route('transaction') }}" class="d-flex justify-content-between">
                            <span><img src="{{ asset('frontend/images/transaction.png') }}" alt=""> Transaction</span>
                            <span class="mr-3"><i class="fas fa-angle-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
