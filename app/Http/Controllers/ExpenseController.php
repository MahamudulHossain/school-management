<?php

namespace App\Http\Controllers;

use DateTime;
use DateInterval;
use Carbon\Carbon;
use App\Models\Expense;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use App\Models\AccountingSinvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('ManageExpense'), redirect('error'));
        $expenses = Expense::orderBy('id','desc')->get();
        return view('expense.index', compact('expenses'));
    }

    public function create()
    {
        abort_if(Gate::denies('ManageExpense'), redirect('error'));
        $expenseTypes = ExpenseType::all();
        return view('expense.create', compact('expenseTypes'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'expense_date' => 'required',
            'expense_amount' => 'required',
        ]);
        $input = $request->all();
        $input['expense_date'] = date('Y-m-d', strtotime($request->expense_date));
        Expense::create($input);
        \Session::flash('flash_success','Successfully Added');
        return redirect('expense');
    }

    public function edit(Expense $expense)
    {
        abort_if(Gate::denies('ManageExpense'), redirect('error'));
        $expenseTypes = ExpenseType::all();
        return view('expense.edit',compact('expense','expenseTypes'));
    }

    public function update(Request $request, Expense $expense)
    {
        $this->validate($request, [
            'expense_date' => 'required',
            'expense_amount' => 'required',
        ]);
        $input = $request->all();
        $input['expense_date'] = date('Y-m-d', strtotime($request->expense_date));
        $expense->update($input);
        \Session::flash('flash_success','Successfully Updated');
        return redirect('expense');
    }
    public function destroy(Expense $expense)
    {
        abort_if(Gate::denies('ManageExpense'), redirect('error'));
        $expense->delete();
        \Session::flash('flash_success','Successfully Deleted');
        return redirect('expense');
    }

    public function balance_report_daterange(){
        // abort_if(Gate::denies('ExpenseBalanceReport'), redirect('error'));
        abort_if(Gate::none(['ExpenseBalanceReport', 'Visitor']), 403, 'Unauthorized');
        return view('expense.balance_report_daterange');
    }

    public function accounting_balance_report(Request $request){
        abort_if(Gate::none(['ExpenseBalanceReport', 'Visitor']), 403, 'Unauthorized');

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $start = Carbon::parse($start_date)->startOfDay();
        $end = Carbon::parse($end_date)->endOfDay();

        // Get minimum dates
        $mindate_invoice = AccountingSinvoice::min('collect_date');
        $mindate_expense = Expense::min('expense_date');

        // If no data in DB yet, use start date as fallback
        $mindate_invoice = $mindate_invoice ?: $start;
        $mindate_expense = $mindate_expense ?: $start;

        // Calculate day before start_date
        $before1day = $start->copy()->subDay()->endOfDay();

        // ------------------- B/D CALCULATIONS -------------------

        // Expenses before start date
        $bd_total_expense = Expense::query()
            ->whereBetween('expense_date', [$mindate_expense, $before1day])
            ->sum('expense_amount');

        // Invoices before start date
        $bd_collectamount = AccountingSinvoice::query()
            ->whereBetween('collect_date', [$mindate_invoice, $before1day])
            ->sum('collect_amount');

        $bd_fine = AccountingSinvoice::query()
            ->whereBetween('collect_date', [$mindate_invoice, $before1day])
            ->sum('fine_amount');

        $bd_discount = AccountingSinvoice::query()
            ->whereBetween('collect_date', [$mindate_invoice, $before1day])
            ->sum('discount_amount');

        $bd_total_income = $bd_collectamount + $bd_fine - $bd_discount;

        // Balance brought down
        $balance_bd = $bd_total_income - $bd_total_expense;

        // ------------------- CURRENT PERIOD -------------------

        // Income
        $income = AccountingSinvoice::orderBy('collect_date', 'desc')
            ->whereBetween('collect_date',[$start_date,$end_date])
            ->get();
        $total_collectamount = AccountingSinvoice::query()
            ->whereBetween('collect_date', [$start, $end])
            ->sum('collect_amount');

        $total_fine = AccountingSinvoice::query()
            ->whereBetween('collect_date', [$start, $end])
            ->sum('fine_amount');

        $total_discount = AccountingSinvoice::query()
            ->whereBetween('collect_date', [$start, $end])
            ->sum('discount_amount');

        $total_income = $total_collectamount + $total_fine - $total_discount;

        // Expense
        $expense = Expense::orderBy('expense_date', 'desc')
            ->whereBetween('expense_date',[$start,$end])
            ->get();

        $total_expense = Expense::query()
            ->whereBetween('expense_date', [$start, $end])
            ->sum('expense_amount');

        // Final balance
        $balance = $balance_bd + $total_income - $total_expense;
        return view('expense.balance_report', compact('expense', 'income','total_expense','total_income','balance',
            'bd_total_expense','bd_total_income','balance_bd','start_date','end_date'));

    }
}
