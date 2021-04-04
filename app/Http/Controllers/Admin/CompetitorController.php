<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Helpers\Helper;
use App\Role;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class CompetitorController extends Controller
{
    protected $request;
    protected $user;
    public function __construct(Request $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    public function index($type = null)
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-competitors')) {
            return view('forbidden_page');
        }

        $users = $this->user->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $users = $users->where('username', 'LIKE', '%' . $this->request->keyword . '%')
                    ->orWhere('fullname', 'LIKE', '%' . $this->request->keyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $this->request->keyword . '%');
            }
            if ($type == 'males') {
                $users = $users->user()->where('gender', 'male')->orderBy('id')->with('country')->paginate(10);
            } elseif ($type == 'females') {
                $users = $users->user()->where('gender', 'female')->orderBy('id')->with('country')->paginate(10);
            } else {
                $users = $users->user()->orderBy('id')->with('country')->paginate(10);
            }


            return view('admin.competitors.partial.partial', compact('users', 'type'));
        }
        if ($type == 'males') {
            $users = $users->user()->where('gender', 'male')->orderBy('id')->with('country')->paginate(10);
        } elseif ($type == 'females') {
            $users = $users->user()->where('gender', 'female')->orderBy('id')->with('country')->paginate(10);
        } else {
            $users = $users->user()->orderBy('id')->with('country')->paginate(10);
        }

        return view('admin.competitors.index', compact('users', 'type'));
    }


    public function competitorsCredits()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-competitors-credits')) {
            return view('forbidden_page');
        }

        $users = $this->user->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $users = $users->where('username', 'LIKE', '%' . $this->request->keyword . '%')
                    ->orWhere('fullname', 'LIKE', '%' . $this->request->keyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $this->request->keyword . '%');
            }
            $users = $users->user()->orderBy('id')->paginate(10);
            return view('admin.competitors.partial.competitors_credits', compact('users'));
        }
        $users = $users->user()->orderBy('id')->paginate(10);

        return view('admin.competitors.competitors_credits', compact('users'));
    }


    public function create()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('create-competitors')) {
            return view('forbidden_page');
        }
        $roles = Role::all();
        $countries = Country::all();
        return view('admin.competitors.create', compact('roles', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Rvequest  $this->request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('create-competitors')) {
            return view('forbidden_page');
        }
        $validator = Validator::make($this->request->all(), [
            'fullname' => 'required',
            'email' => 'required|unique:users,email',
            'type' => 'required|in:user',
            'username' => 'required',
            'password' => 'required',
            'gender' => 'required',
            'image' => 'required',
            'roles' => 'exists:roles,id',
            'phone' => 'required|unique:users,phone',

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
        $user->gender = $this->request->gender;
        $user->type = $this->request->type;
        $user->country_id = $this->request->country_id;
        $user->phone = $this->request->phone;

        $user->password = Hash::make($this->request->password);
        if (isset($this->request->image) && !empty($this->request->image)) {
            $imageName = Helper::upload_user_image($this->request->image);
            $user->image = $imageName;
        }
        $user->save();
        if (isset($this->request->roles) && $user->type == 'sub_admin') {

            $user->roles()->sync($this->request->roles);
        }
        if ($user) {
            return redirect('/all-competitors')->with('success', 'تم إضافة المشترك بنجاح');
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
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-competitors')) {
            return view('forbidden_page');
        }
        $user = $this->user->find($id);
        if ($id == 1 && auth()->user()->id != 1) {
            return view('forbidden_page');
        }
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
        if ($id == 1 && auth()->user()->id != 1) {
            return view('forbidden_page');
        }
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-competitors')) {
            return view('forbidden_page');
        }
        $countries = Country::all();

        $roles = Role::all();
        $user = User::findOrFail($id);
        return view('admin.competitors.edit', compact('user', 'roles', 'countries'));
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
        if ($this->request->user_id == 1 && auth()->user()->id != 1) {
            return view('forbidden_page');
        }

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-competitors')) {
            return view('forbidden_page');
        }
        $validator = Validator::make($this->request->all(), [
            'fullname' => 'required',
            'email' => 'required|unique:users,email,' . $this->request->user_id,
            'type' => 'required|in:user',
            'username' => 'required',
            'gender' => 'required',
            'roles' => 'exists:roles,id',
            'phone' => 'required|unique:users,phone',

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
        $user->fullname = $this->request->fullname;
        $user->username = $this->request->username;
        $user->email = $this->request->email;
        $user->gender = $this->request->gender;
        $user->type = $this->request->type;
        $user->country_id = $this->request->country_id;
        $user->phone = $this->request->phone;

        if ($user->type != 'sub_admin') {
            $user->roles()->sync([]);
        } else {
            $user->roles()->sync($this->request->roles);
        }
        if (isset($this->request->password)) {
            $user->password = Hash::make($this->request->password);
        }
        if (isset($this->request->image) && !empty($this->request->image)) {
            $imageName = Helper::upload_user_image($this->request->image);
            $user->image = $imageName;
        }
        $user->save();
        if ($user) {
            return redirect('/all-competitors')->with('success', 'تم تعديل المشترك بنجاح');
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
        if ($id == 1) {
            return view('forbidden_page');
        }
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('delete-competitors')) {
            return view('forbidden_page');
        }
        $user = User::findOrFail($id);
        if ($user->delete()) {
            return redirect()->back()->with('success', 'تم حذف المشترك بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    public function login_form()
    {
        return view('auth.User.login');
    }

    public function changeCompetitorStatus($id)
    {
        if ($id == 1 && auth()->user()->id != 1) {
            return view('forbidden_page');
        }
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-competitors')) {
            return view('forbidden_page');
        }
        $user = User::findOrFail($id);
        if ($user->status == 0) {
            $user->status = 1;
        } else {
            $user->status = 0;
        }
        $user->save();
        return redirect('/all-competitors')->with('success', 'تم تعديل المشترك بنجاح');
    }
}
