<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Helpers\Helper;
use App\Role;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    protected $request;
    protected $user;
    public function __construct(Request $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    public function index()
    {

        $users = $this->user->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $users = $users->where('username', 'LIKE', '%' . $this->request->keyword . '%')->where('type', 'user');
            }
            $users = $users->orderBy('id')->where('type', 'user')->paginate(10);

            return view('admin.users.partial.partial', compact('users'));
        }
        $users = $users->orderBy('id')->where('type', 'user')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {


        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Rvequest  $this->request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        $validator = Validator::make($this->request->all(), [
            'fullname' => 'required',
            'email' => 'required|unique:users,email',
            'username' => 'required|min:1|max:255',
            'password' => 'required|min:3|max:255',
            'image' => 'required|max:10000',
        ]);
        if ($validator->fails()) {
            $errors = [];
            $index = 0;

            foreach ($validator->errors()->getMessages() as $key => $error) {
                $errors[$index] = $error[0];
                $index++;
            }

            return redirect()->back()->withErrors($validator->errors());
        }


        $user = $this->user;
        $user->fullname = $this->request->fullname;
        $user->username = $this->request->username;
        $user->email = $this->request->email;
        $user->password = Hash::make($this->request->password);
        if (isset($this->request->image) && !empty($this->request->image)) {
            $imageName = Helper::upload_user_image($this->request->image);
            $user->image = $imageName;
        }
        $user->save();

        if ($user) {
            return redirect('/all-users')->with('success', 'تم إضافة المستخدم بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = $this->user->find($id);

        return view('admin.users.single_user', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = User::findOrFail($id);
        if ($user->type == 'admin') {
            abort(403);
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $this->request
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update()
    {

        $validator = Validator::make($this->request->all(), [
            'fullname' => 'required',
            'email' => 'required|unique:users,email,' . $this->request->user_id,
            'username' => 'required',


        ]);
        if ($validator->fails()) {
            $errors = [];
            $index = 0;

            foreach ($validator->errors()->getMessages() as $key => $error) {
                $errors[$index] = $error[0];
                $index++;
            }

            return redirect()->back()->withErrors($validator->errors());
        }


        $user = $this->user->find($this->request->user_id);

        if ($user->type == 'admin') {
            abort(403);
        }

        $user->fullname = $this->request->fullname;
        $user->username = $this->request->username;
        $user->email = $this->request->email;
        if (isset($this->request->password) && !empty($this->request->password)) {
            $user->password = Hash::make($this->request->password);
        }


        if (isset($this->request->image) && !empty($this->request->image)) {
            $imageName = Helper::upload_user_image($this->request->image);
            $user->image = $imageName;
        }
        $user->save();
        if ($user) {
            return redirect('/all-users')->with('success', 'تم تعديل المستخدم بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $user = User::findOrFail($id);
        if ($user->type == 'admin') {
            abort(403);
        }
        if ($user->delete()) {
            return redirect()->back()->with('success', 'تم حذف المستخدم بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }



    public function changeUserStatus($id)
    {

        $user = User::findOrFail($id);
        if ($user->type == 'admin') {
            abort(403);
        }
        if ($user->status == 0) {
            $user->status = 1;
        } else {
            $user->status = 0;
        }
        $user->save();
        return redirect('/all-users')->with('success', 'تم تعديل المستخدم بنجاح');
    }
}
