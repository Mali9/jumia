<?php

namespace App\Http\Controllers\Admin;

use App\Room;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    protected $request;
    protected $room;
    public function __construct(Request $request, Room $room)
    {
        $this->request = $request;
        $this->room = $room;
    }

    public function index()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-rooms')) {
            return view('forbidden_page');
        }

        $rooms = $this->room->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $rooms = $rooms->where('id', 'LIKE', '%' . $this->request->keyword . '%');
            }
            $rooms = $rooms->paginate(10);
            return view('admin.rooms.partial.partial', compact('rooms'));
        }
        $rooms = $rooms->paginate(10);

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('create-rooms')) {
            return view('forbidden_page');
        }
        $rooms = room::all();
        return view('admin.rooms.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Rvequest  $this->request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('create-rooms')) {
            return view('forbidden_page');
        }
        $validator = Validator::make($this->request->all(), [
            'room_credit' => 'required',
            'credit_per_question' => 'required',
            'type' => 'required',
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
        if ($this->request->credit_per_question >= $this->request->room_credit) {
            return redirect()->back()->with('error', 'يجب أن يكون المبلغ المرصود للغرفة أكبر من المبلغ المرصود للسؤال الواحد');
        }

        $room = $this->room;
        $room->room_credit = $this->request->room_credit;
        $room->credit_per_question = $this->request->credit_per_question;
        $room->type = $this->request->type;
        $room->status = $this->request->status;
        $room->save();
        if ($room) {
            return redirect('/all-rooms')->with('success', 'تم إضافة الغرفة بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\room  $room
     * @return \Illuminate\Http\Response
     */


    public function edit($id)
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-rooms')) {
            return view('forbidden_page');
        }

        $room = $this->room->findOrFail($id);
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $this->request
     * @param  \App\room  $room
     * @return \Illuminate\Http\Response
     */
    public function update()
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-rooms')) {
            return view('forbidden_page');
        }
        $validator = Validator::make($this->request->all(), [
            'room_credit' => 'required',
            'credit_per_question' => 'required',
            'type' => 'required',
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


        $room = $this->room->find($this->request->room_id);
        $room->room_credit = $this->request->room_credit;
        $room->credit_per_question = $this->request->credit_per_question;
        $room->type = $this->request->type;
        $room->status = $this->request->status;

        $room->save();
        if ($room) {
            return redirect('/all-rooms')->with('success', 'تم تعديل الغرفة بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\room  $room
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('delete-rooms')) {
            return view('forbidden_page');
        }
        $room = $this->room->findOrFail($id);
        if ($room->delete()) {
            return redirect()->back()->with('success', 'تم حذف الغرفة بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }
}
