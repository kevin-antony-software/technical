<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankDetail;
use App\Models\Cash;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arr['expenses'] = Expense::orderBy('id', 'desc')->get();
        return view('admin.expense.index')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $arr['banks'] = Bank::all();
        return view('admin.expense.create')->with($arr);
    }
    public function compress_image($source_url, $destination_url, $quality)
    {
        $info = getimagesize($source_url);

        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        elseif ($info['mime'] == 'image/jpg') $image = imagecreatefromjpeg($source_url);

        imagejpeg($image, $destination_url, $quality);

        return $destination_url;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'to' => 'required',
            'amount' => 'required|numeric',
            'image1' => 'image|nullable',
            'reason' => 'string',
        ]);
        $idIN = DB::select("SHOW TABLE STATUS LIKE 'expenses'");
        $next_id = $idIN[0]->Auto_increment;

        $folder = 'expenses_images/expense_' . $next_id;
        if (!File::isDirectory($folder)) {
            File::makeDirectory($folder, 0777, true, true);
        }

        // $folder = 'expenses_images/expense_' . $next_id . '/';

        if ($request->hasFile('image1')) {
            $file = $request->file('image1');
            $extension = $file->getClientOriginalExtension();

            $namecreate = "image_" . $next_id;
            $finalname = $namecreate . "." . $extension;
            $dest_photo = $folder . '/' . $finalname;
            $this->compress_image($file, $dest_photo, 25);
        }

        if ($request->method == "cash") {
            $data = DB::table('cashes')
                ->latest()
                ->first();

            if ($data) {
                $balance = $data->balance - $request->amount;

                if ($balance < 0) {
                    return redirect()->route('expense.create')->with('error', 'not enough funds')->withInput();
                } else {
                    $expense = new Expense();
                    $expense->to = $request->to;
                    $expense->reason = $request->reason;
                    $expense->amount = $request->amount;
                    $user = auth()->user();
                    $expense->user_id = $user->id;
                    $expense->save();

                    $cash = new Cash();
                    $cash->expense_id = $next_id;
                    $cash->category = "Expense";
                    $cash->amount = $request->amount;
                    $cash->balance = $balance;
                    $cash->save();
                    return redirect()->route('expense.index')->with('message', 'new Expense saved');
                }
            } else {
                return redirect()->route('expense.create')->with('error', 'no cash')->withInput();
            }
        } elseif ($request->method == "Bank Transfer") {
            $Abalance = Bank::where('id', $request->bank)->first()->balance;
            if ($Abalance) {
                if ((($Abalance) - ($request->amount)) < 0) {

                    return redirect()->route('expense.create')->withInput()->with('error', 'not enough funds in this bank');
                } else {
                    $expense = new Expense();
                    $expense->to = $request->to;
                    $expense->reason = $request->reason;
                    $expense->amount = $request->amount;
                    $user = auth()->user();
                    $expense->user_id = $user->id;
                    $expense->save();

                    $bankDetail = new BankDetail();
                    $bankDetail->bank_id = $request->bank;
                    $bankDetail->expense_id = $next_id;
                    $bankDetail->amount = $request->amount;
                    $bankDetail->debit_amount = $request->amount;
                    $bankDetail->bank_balance = $Abalance - $request->amount;
                    $bankDetail->reason = "Expense ID - " . $next_id . " reason - " . $request->reason;
                    Bank::where('id', $request->bank)->decrement('balance', $request->amount);
                    $bankDetail->save();
                    return redirect()->route('expense.index')->with('message', 'new Expense saved');
                }
            } else {
                return redirect()->route('expense.create')->withInput()->with('error', 'no bank still');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        $folder = 'expenses_images/expense_' . $expense->id . '/';
        $images = File::files($folder);

        return view('admin.expense.show', [
            'images' => $images,
            'expense' => $expense,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
