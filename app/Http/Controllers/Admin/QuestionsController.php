<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;

class QuestionsController extends Controller
{
    protected $request;
    protected $question;
    public function __construct(Request $request, Question $question)
    {
        $this->request = $request;
        $this->question = $question;
    }

    public function index()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-questions')) {
            return view('forbidden_page');
        }

        $questions = $this->question->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $questions = $questions->where('question', 'LIKE', '%' . $this->request->keyword . '%');
            }
            $questions = $questions->paginate(10);
            return view('admin.questions.partial.partial', compact('questions'));
        }
        $questions = $questions->paginate(10);

        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('create-questions')) {
            return view('forbidden_page');
        }
        return view('admin.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Rvequest  $this->request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('create-questions')) {
            return view('forbidden_page');
        }
        $validator = Validator::make($this->request->all(), [
            'question' => 'required',
            'answers' => 'required|array|size:4',
            'right_answer' => 'required|in:A,B,C,D',
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

        $question = $this->question;
        $question->question = $this->request->question;
        $question->right_answer = $this->request->right_answer;
        $question->save();
        // dd($this->request->answers);
        $num = 'A';
        foreach ($this->request->answers as  $key => $answer) {
            if ($key === 1) {
                $num = 'B';
            } elseif ($key === 2) {
                $num = 'C';
            } elseif ($key === 3) {
                $num = 'D';
            }
            Answer::create([
                'answer' => $answer,
                'answer_num' => $num,
                'question_id' => $question->id
            ]);
        }

        if ($question) {
            return redirect('/all-questions')->with('success', 'تم إضافة السؤال بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */


    public function edit($id)
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-questions')) {
            return view('forbidden_page');
        }

        $question = $this->question->findOrFail($id);
        return view('admin.questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $this->request
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function update()
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-questions')) {
            return view('forbidden_page');
        }
        $validator = Validator::make($this->request->all(), [
            'question' => 'required',
            'answers' => 'required|array|size:4',
            'right_answer' => 'required|in:A,B,C,D',
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


        $question = $this->question->find($this->request->question_id);
        $question->question = $this->request->question;
        $question->right_answer = $this->request->right_answer;
        $question->save();
        // dd($this->request->answers);
        $answers = Answer::where('question_id', $question->id)->get();
        $num = 'A';

        foreach ($this->request->answers as  $key => $answer) {
            if ($key === 1) {
                $num = 'B';
            } elseif ($key === 2) {
                $num = 'C';
            } elseif ($key === 3) {
                $num = 'D';
            }
            Answer::where('id', $answers[$key]->id)->update([
                'answer' => $answer, 'answer_num' => $num,

            ]);
        }
        if ($question) {
            return redirect('/all-questions')->with('success', 'تم تعديل السؤال بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('delete-questions')) {
            return view('forbidden_page');
        }
        $question = $this->question->findOrFail($id);
        $question->answers()->delete();

        if ($question->delete()) {
            return redirect()->back()->with('success', 'تم حذف السؤال بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }
}
