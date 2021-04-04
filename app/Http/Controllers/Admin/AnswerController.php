<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;

class AnswerController extends Controller
{
    protected $request;
    protected $answer;
    public function __construct(Request $request, Answer $answer)
    {
        $this->request = $request;
        $this->answer = $answer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-answers')) {
            return view('forbidden_page');
        }

        $answers = $this->answer->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $answers = $answers->where('answer', 'LIKE', '%' . $this->request->keyword . '%');
            }
            $answers = $answers->latest()->paginate(10);
            return view('admin.answers.partial.partial', compact('answers'));
        }
        $answers = $answers->latest()->paginate(10);

        return view('admin.answers.index', compact('answers'));
    }

    public function getQuestionAnswers($question_id)
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-answers')) {
            return view('forbidden_page');
        }

        $answers = $this->answer->query();

        $answers = $answers->where('question_id', $question_id)->latest()->paginate(10);

        return view('admin.answers.index', compact('answers'));
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id == 1 && auth()->user()->id != 1) {
            return view('forbidden_page');
        }
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-answers')) {
            return view('forbidden_page');
        }

        $answer = $this->answer->findOrFail($id);
        return view('admin.answers.edit', compact('answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-answers')) {
            return view('forbidden_page');
        }
        $validator = Validator::make($this->request->all(), [
            'answer' => 'required',
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


        $answer = $this->answer->find($this->request->answer_id);
        $answer->answer = $this->request->answer;
        $answer->save();

        if ($answer) {
            return redirect('/all-answers')->with('success', 'تم تعديل الاجابة بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }
}
