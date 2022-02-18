<?php

namespace App\Http\Controllers\Backend;

use App\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    public function index()
    {
        return view('backend.wallet.index');
    }

    public function ssd()
    {
        $wallets = Wallet::with('user');
        return Datatables::of($wallets)
        ->addColumn('account_person', function($each) {
            $user = $each->user;
            if ($user) {
                return '<p>Name: '. $user->name .' </p><p>Email: '. $user->email .' </p><p>Phone: '. $user->phone .' </p>';
            }
            return '-';
        })
        ->editColumn('amount', function($each) {
            return number_format($each->amount, 2);
        })
        ->editColumn('created_at', function($each) {
            return Carbon::parse($each->created_at)->format('Y-m-d H:i:s');
        })
        ->editColumn('updated_at', function($each) {
            return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
        })
        ->rawColumns(['account_person'])
        ->make(true);
    }
}
