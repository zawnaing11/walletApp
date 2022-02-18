<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\UUIDGenerate;
use App\User;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\transferFormRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Route;

class PageController extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }
    public function profile()
    {
        $user = auth()->user();
        return view('frontend.profile', compact('user'));
    }

    public function updatePassword()
    {
        return view('frontend.update_password');
    }

    public function updatePasswordStore(UpdatePasswordRequest $request)
    {
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $user = Auth::guard('web')->user();
        if (Hash::check($old_password, $user->password)) {
            $user->password = Hash::make($new_password);
            $user->update();

            return redirect()->route('profile')->with('update', 'Successfully Updated');
        }
        return redirect()->route('update-password')->withErrors(['old_password' => 'old password does not correct!']);
    }

    public function wallet()
    {
        $currentUser = auth()->guard('web')->user();
        return view('frontend.wallet', compact('currentUser'));
    }

    public function transfer()
    {
        return view('frontend.transfer');
    }

    public function transferHash(Request $request)
    {
        $str = $request->phone.$request->amount.$request->description;
        $hash_value = hash_hmac('md5', $str, 'wallet@pp');
        return response()->json([
            'status' => true,
            'data' => $hash_value
        ]);

    }

    public function transferConfrim(transferFormRequest $request)
    {
        return $request->all();
        if ($request['amount'] < 1000) {
            return back()->withErrors(['amount' => 'The amount must be at lease 1000 MMK.'])->withInput();
        }
        if ($request->phone == auth()->user()->phone) {
            return back()->withErrors(['phone' => "can't transition with the same phone number."])->withInput();
        }
        $receiver = User::where('phone', $request->phone)->first();
        if (!$receiver) {
            return back()->withErrors(['receiver' => 'User does not have this phone number'])->withInput();
        }
        $data = $request->all();
        return view('frontend.transfer_confirm', compact('data', 'receiver'));
    }

    public function transferComplete(transferFormRequest $request)
    {
        if ($request['amount'] < 1000) {
            return back()->withErrors(['error' => 'The amount must be at lease 1000 MMK.'])->withInput();
        }
        if ($request->phone == auth()->user()->phone) {
            return back()->withErrors(['error' => "can't transition with the same phone number."])->withInput();
        }
        $receiverUser = User::where('phone', $request->phone)->first();
        if (!$receiverUser) {
            return back()->withErrors(['error' => 'User does not have this phone number'])->withInput();
        }
        if (!auth()->user()->wallet || !$receiverUser->wallet) {
            return back()->withErrors(['error' => 'Something went worng!'])->withInput();
        }
        DB::beginTransaction();
        try {
            $senderUser = auth()->user();
            $senderUser->wallet->decrement('amount', $request->amount);
            $senderUser->update();

            $receiverUser->wallet->increment('amount', $request->amount);
            $receiverUser->update();

            $refNo = UUIDGenerate::refNo();
            $senderTransaction = new Transaction();
            $senderTransaction->ref_no = $refNo;
            $senderTransaction->trs_id = UUIDGenerate::trsId();
            $senderTransaction->sender_id = $senderUser->id;
            $senderTransaction->receiver_id = $receiverUser->id;
            $senderTransaction->type = 2;
            $senderTransaction->amount = $request->amount;
            $senderTransaction->description = $request->description;
            $senderTransaction->save();

            $receiverTransaction = new Transaction();
            $receiverTransaction->ref_no = $refNo;
            $receiverTransaction->trs_id = UUIDGenerate::trsId();
            $receiverTransaction->sender_id = $receiverUser->id;
            $receiverTransaction->receiver_id = $senderUser->id;
            $receiverTransaction->type = 1;
            $receiverTransaction->amount = $request->amount;
            $receiverTransaction->description = $request->description;
            $receiverTransaction->save();

            DB::commit();
            return redirect()->route('transaction.detail', ['trs_id' => $senderTransaction->trs_id, 'status' => 1])->with('success', 'successfully transfered.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['fail' => $e->getMessage()]);
        }

    }
    public function passwordCheck(Request $request)
    {
        if (Hash::check($request->password, auth()->user()->password)) {
            return response()->json([
                'status' => true,
                'message' => 'The password is correct!'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'The password is incorrect.'
        ]);
    }
    public function toAccountVerify(Request $request)
    {
        $user = [];
        if ($request->phone != auth()->user()->phone) {
            $user = User::where('phone', $request->phone)->first();
            if ($user) {
                return response()->json([
                    'status' => true,
                    'message' => 'success',
                    'data' => $user
                ]);
            }
        }
        return response()->json([
            'status' => false,
            'message' => 'fail'
        ]);
    }

    public function transaction(Request $request)
    {
        $currentUser = auth()->user();
        $query = Transaction::with('receiverUser', 'senderUser')
            ->orderBy('created_at', 'desc')
            ->where('sender_id', $currentUser->id);
        if ($request->type) {
            $query = $query->where('type', $request->type);
        }
        if ($request->date) {
            $query = $query->whereDate('created_at', $request->date);
        }
        $transactions = $query->paginate(5);
        return view('frontend.transaction', compact('transactions'));
    }

    public function transactionDetail($trsId, $status)
    {
        $transaction = Transaction::with('receiverUser', 'senderUser')
            ->where('sender_id', auth()->user()->id)
            ->where('trs_id', $trsId)
            ->first();
        return view('frontend.transaction_detail', compact('transaction', 'status'));
    }
}
