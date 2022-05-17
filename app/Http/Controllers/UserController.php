<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(private UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index(Request $request)
    {
        $per_page = $request->per_page ? $request->currentPage : 10;
        $users = $this->userRepository->paginateData($per_page);
        if ($request->ajax()){
            return response()->json($users, 200);
        }
        return view('pages.user.index', compact('users'));
    }

    public function create()
    {
        $prefixname = [
            'Mr.',
            'Mrs.',
            'Ms.'
        ];

        return view('pages.user.create', compact('prefixname'));
    }

    public function store(UserRequest $request)
    {
        // return $request;
        try {
            $user = $this->userRepository->store($request->all());
            if ($request->hasFile('photo')) {
                $this->userRepository->updateProductImage($user, $request->photo);
            }
            if ($request->ajax()){
                return response()->json($user, 201);
            }
            return redirect()->back()->with('success', 'User created successfully!');
        } catch (\Throwable $th) {
            \Log::info($th);
            return response()->back()->with('error', 'Ops! Something went wrong. Strace stack : "'. $th->getMessage() .'"');
        }
    }

    public function edit(User $user)
    {
        $prefixname = [
            'Mr.',
            'Mrs.',
            'Ms.'
        ];

        return view('pages.user.edit', compact('prefixname', 'user'));
    }

    public function show(Request $request, User $user)
    {
        $prefixname = [
            'Mr.',
            'Mrs.',
            'Ms.'
        ];

        if ($request->ajax()){
            $d = User::find($request->user);
            $data = [
                'prefixname' => $d['prefixname'],
                'firstname' => $d['firstname'],
                'middlename' => $d['middlename'],
                'lastname' => $d['lastname'],
                'email' => $d['email'],
                'username' => $d['username']
            ];
            return response()->json($d, 200);
        }

        return view('pages.user.view', compact('prefixname', 'user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->userRepository->update($id, $request->all());
            if ($request->hasFile('photo')) {
                $this->userRepository->updateProductImage($user, $request->photo);
            }

            if ($request->ajax()){
                return response()->json($user, 200);
            }

            return redirect()->back()->with('success', 'User updated successfully!');
        } catch (\Throwable $th) {
            \Log::info($th);
            return response()->back()->with('error', 'Ops! Something went wrong. Strace stack : "'. $th->getMessage() .'"');
        }
    }

    public function destroy(Request $request, $id)
    {

        try {
            $this->userRepository->delete($id);
            if ($request->ajax()){
                return response()->json(null, 200);
            }
            return redirect()->route('users.index')->with('success', 'User was transfered to archive list!');
        } catch (\Throwable $th){
            \Log::info($th);
            return response()->back()->with('error', 'Ops! Something went wrong. Strace stack : "'. $th->getMessage() .'"');
        }
    }

    public function trashed(Request $request)
    {
        $users = $this->userRepository->trashed();
        if ($request->ajax()){
            return response()->json($users, 200);
        }

        return view('pages.user.trashed_users', compact('users'));
    }

    public function restore(Request $request, $user)
    {
        try {
            User::onlyTrashed()->find($user)->restore();
            if ($request->ajax()){
                return response()->json(null, 200);
            }
            return redirect()->back()->with('success', 'Restored successfully! User is available on user list.');
        } catch (\Throwable $th){
            \Log::info($th);
            return response()->back()->with('error', 'Ops! Something went wrong. Strace stack : "'. $th->getMessage() .'"');
        }
    }

    public function delete(Request $request, $user)
    {
        try {
            User::onlyTrashed()->find($user)->forceDelete();
            if ($request->ajax()){
                return response()->json(null, 200);
            }
            return redirect()->back()->with('success', 'Deleted successfully! User was remove in the system.');
        } catch (\Throwable $th){
            \Log::info($th);
            return response()->back()->with('error', 'Ops! Something went wrong. Strace stack : "'. $th->getMessage() .'"');
        }
    }
}
