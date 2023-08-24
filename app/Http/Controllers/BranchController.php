<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Day;
use App\Models\TheoryClass;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;

class BranchController extends Controller {
    public function index() {
        $data = [
            'users' => User::role(2)->get(),
            'branches' => Branch::with('theory_class.days')->get(),
            'days' => Day::all(),
        ];
        return view('admin.branches.index', $data);
    }

    public function show($id) {
        // $branch = Branch::find($id)->with('manager')->get();
        // $branch = User::find($id);
        $data = 'nai';
        if (auth()->user()->branch) {
            $data = count(auth()->user()->branch);
        }
        return $data;
    }

    public function edit($id) {
        $branch = Branch::with('theory_class.days')->find($id);
        $data = [
            'page_title' => 'Edit Branch: ' . $branch->branch_name,
            'branch' => $branch,
            'days' => Day::all(),
            'users' => User::role(2)->get()
        ];
        return view('admin.branches.edit', $data);
    }

    public function update(Request $request) {
        $request->validate([
            '*' => 'required',
            'theory_classes' => 'required',
        ]);
        Branch::find($request->branch_id)->update([
            'branch_name' => $request->branch_name,
            'branch_address' => $request->branch_address,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        TheoryClass::where('branch_id', $request->branch_id)->delete();

        foreach ($request->theory_classes as $class) {
            TheoryClass::create([
                'day' => $class,
                'branch_id' => $request->branch_id,
            ]);
        }

        return back()->with('success', 'Branch updated successful');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'branch_name' => 'required',
            'branch_address' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'theory_classes' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            $branch = Branch::create([
                'branch_name' => $request->branch_name,
                'branch_address' => $request->branch_address,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            foreach ($request->theory_classes as $class) {
                TheoryClass::create([
                    'day' => $class,
                    'branch_id' => $branch->id,
                ]);
            }
            session()->flash('success', 'Branch added successfully!');
            return response()->json(['success' => true]);
        }
    }

    public function assign(Request $request) {
        if (auth()->user()->roles->first()->id == 1) {
            $user = User::find($request->user_id);
            $user->update([
                'branch_id' => $request->branch_id
            ]);
            session()->flash('success', 'Branch assigned successfully!');
        } else {
            session()->flash('error', 'Access denied!');
        }
    }

    public function assign_modal($id) {
        return view('admin.madals.assign-branch', [
            'branches' => Branch::all(),
            'user' => User::find($id)
        ]);
    }

    public function upload_signature_modal($id) {
        return view('admin.madals.upload-signature', [
            'id' => $id
        ]);
    }

    function upload_signature(Request $request) {
        $validator = Validator::make($request->all(), [
            'signature' => 'required|mimes:jpeg,png,jpg'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            $branch = Branch::find($request->branch_id);
            $signature = $request->file('signature');
            $file_name = Str::lower('signature-' . $request->branch_id . '-' . uniqid() . '.' . $signature->getClientOriginalExtension());
            if ($branch->branch_manager_signature != '') {
                unlink(public_path('/uploads/signature/' . $branch->branch_manager_signature));
            }
            Image::make($signature)
                ->resize(null, 80, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('/uploads/signature/' . $file_name));
            $branch->update([
                'branch_manager_signature' => $file_name
            ]);
            session()->flash('success', 'Signature added successfully!');
            return response()->json(['success' => true]);
        }
    }
    public function edit_signature_modal($id) {
        return view('admin.madals.edit-signature', [
            'branch' => Branch::find($id),
        ]);
    }

    function edit_signature(Request $request) {
        $validator = Validator::make($request->all(), [
            'signature' => 'required|mimes:jpeg,png,jpg'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            $branch = Branch::find($request->branch_id);
            $signature = $request->file('signature');
            $file_name = Str::lower('signature-' . $request->branch_id . '-' . uniqid() . '.' . $signature->getClientOriginalExtension());
            unlink(public_path('/uploads/signature/' . $branch->branch_manager_signature));
            Image::make($signature)
                ->resize(null, 80, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('/uploads/signature/' . $file_name));
            $branch->update([
                'branch_manager_signature' => $file_name
            ]);
            session()->flash('success', 'Signature uploaded successfully!');
            return response()->json(['success' => true]);
        }
    }

    function branch_status_update(Request $request, $id) {
        $branch = Branch::find($id);

        $branch->update([
            'status' => $request->status
        ]);
        return back()->with('success', 'Status updated successfully!');
    }
}
