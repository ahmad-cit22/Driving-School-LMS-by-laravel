<?php

namespace App\Http\Controllers;

use App\Models\AccountExpense;
use App\Models\AccountIncome;
use App\Models\Branch;
use App\Models\Enroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller {
    public function income() {

        return view('admin.accounts.income.income', [
            'incomes' => AccountIncome::orderBy('created_at', 'desc')->get(),
            'branches' => Branch::all()
        ]);
    }

    public function income_add(Request $request) {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'branch' => 'required|not_in:0',
        ], [
            'branch.not_in' => 'Please select a branch.'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            AccountIncome::create([
                'amount' => $request->amount,
                'branch_id' => $request->branch,
                'note' => $request->note,
            ]);

            session()->flash('success', 'New Income Entry Added successfully!');
            return response()->json(['success' => true]);
        }
    }

    public function income_edit_modal($id) {
        if (auth()->user()->hasRole(1)) {
            return view('admin.madals.edit-income', [
                'income' => AccountIncome::find($id),
                'enrolls' => Enroll::all(),
                'branches' => Branch::all()
            ]);
        } else {
            return response()->json(['error' => true]);
        }
    }

    public function income_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'branch' => 'required|not_in:0',
            'enroll_id' => 'not_in:0',
        ], [
            'branch.not_in' => 'Please select a branch.',
            'enroll_id.not_in' => 'Please select a valid enrolled student.'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            if (auth()->user()->hasRole(1)) {
                $income = AccountIncome::find($request->id);

                $income->update([
                    'amount' => $request->amount,
                    'branch_id' => $request->branch,
                    'enroll_id' => $request->enroll_id,
                    'note' => $request->note,
                ]);

                session()->flash('success', 'Income Entry Updated successfully!');
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => true]);
            }
        }
    }

    public function income_delete($id) {
        if (auth()->user()->hasRole(1)) {
            if (AccountIncome::find($id)->delete()) {
                return back()->with('success', 'Income Entry Deleted Successfully');
            } else {
                return back()->with('error', 'Something went wrong');
            }
        } else {
            return back()->with('error', 'Unauthorized access!');
        }
    }

    public function expense() {

        return view('admin.accounts.expense.expense', [
            'expenses' => AccountExpense::orderBy('created_at', 'desc')->get(),
            'branches' => Branch::all()
        ]);
    }

    public function expense_add(Request $request) {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'branch' => 'required|not_in:0',
        ], [
            'branch.not_in' => 'Please select a branch.'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            AccountExpense::create([
                'amount' => $request->amount,
                'branch_id' => $request->branch,
                'note' => $request->note,
            ]);

            session()->flash('success', 'New Expense Entry Added successfully!');
            return response()->json(['success' => true]);
        }
    }

    public function expense_edit_modal($id) {
        if (auth()->user()->hasRole(1)) {
            return view('admin.madals.edit-expense', [
                'expense' => AccountExpense::find($id),
                'branches' => Branch::all()
            ]);
        } else {
            return response()->json(['error' => true]);
        }
    }

    public function expense_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'branch' => 'required|not_in:0',
        ], [
            'branch.not_in' => 'Please select a branch.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            if (auth()->user()->hasRole(1)) {
                $expense = AccountExpense::find($request->id);

                $expense->update([
                    'amount' => $request->amount,
                    'branch_id' => $request->branch,
                    'note' => $request->note,
                ]);

                session()->flash('success', 'Expense Entry Updated successfully!');
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => true]);
            }
        }
    }

    public function expense_delete($id) {
        if (auth()->user()->hasRole(1)) {
            if (AccountExpense::find($id)->delete()) {
                return back()->with('success', 'Expense Entry Deleted Successfully');
            } else {
                return back()->with('error', 'Something went wrong');
            }
        } else {
            return back()->with('error', 'Unauthorized access!');
        }
    }
}
