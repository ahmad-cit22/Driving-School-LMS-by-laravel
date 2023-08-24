<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\CourseCategory;
use App\Models\CourseType;
use App\Models\Enroll;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizScore;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller {

    //quizzes list

    public function index() {
        return view('admin.quizzes.index', [
            'course_categories' => CourseCategory::all(),
            'course_types' => CourseType::all(),
            'quizzes' => Quiz::all(),
        ]);
    }

    public function add(Request $request) {
        $request->validate([
            'course_category' => 'required',
            'course_type' => 'required',
            'quiz_name' => 'required',
            'time_limit' => 'required',
            'quiz_status' => 'required',
        ], [
            'course_category.required' => 'Please select the course category.',
            'course_type.required' => 'Please select the course type.',
            'quiz_name.required' => 'Please enter a name for the quiz.',
            'time_limit.required' => 'Please set a time limit for the quiz.',
            'quiz_status.required' => 'Please set the status of the quiz.',
        ]);

        $quiz_info = Quiz::create([
            'course_id' => $request->course_category,
            'course_type' => $request->course_type,
            'quiz_name' => $request->quiz_name,
            'time_limit' => $request->time_limit,
            'quiz_status' => $request->quiz_status,
            // 'quiz_privacy' => $request->quiz_privacy,
            'created_at' => Carbon::now(),
        ]);

        return back()->with('addSuccess', 'Quiz Added Successfully!');
    }

    public function questions($q_id) {
        $quiz_info = Quiz::find($q_id);
        $questions = Question::where('quiz_id', $quiz_info->id)->get();

        return view('admin.quizzes.questions.index', [
            'q_id' => $q_id,
            'quiz_info' => $quiz_info,
            'questions' => $questions,
        ]);
    }

    public function store_questions(Request $request, $q_id) {
        $quiz_info = Quiz::find($q_id);
        $choices = $request->choice;

        $request->validate([
            'question' => 'required',
            'question_type' => 'required',
            'choice' => 'required',
            'right_answer' => 'required',
            'marks' => 'required',
        ], [
            'question.required' => 'Please enter the question.',
            'question_type.required' => 'Please select the type of the question.',
            'choice.required' => 'Please enter the choices for the question.',
            'right_answer.required' => 'Please set the right answer for the question.',
            'marks.required' => 'Please enter the marks for the question.',
        ]);

        $question_id = Question::insertGetId([
            'quiz_id' => $q_id,
            'course_id' => $quiz_info->course_id,
            'course_type' => $quiz_info->course_type,
            'question' => $request->question,
            'question_type' => $request->question_type,
            'right_answer' => $request->right_answer,
            'marks' => $request->marks,
            'created_at' => Carbon::now(),
        ]);

        foreach ($choices as $key => $choice) {
            Choice::insert([
                'question_id' => $question_id,
                'choice' => $choice,
                'is_correct' => $request->right_answer == $key + 1 ? 1 : 0,
                'created_at' => Carbon::now(),
            ]);
        }

        $question = Question::where('quiz_id', $q_id);

        $quiz_info->update([
            'total_questions' =>  $question->count(),
            'total_marks' =>  $question->sum('marks'),
        ]);

        return back()->with('addSuccess', 'Question Added Successfully!');
    }

    public function quiz_edit_modal($id) {
        return view('admin.madals.edit-quiz', [
            'quiz' => Quiz::find($id),
            'course_categories' => CourseCategory::all(),
            'course_types' => CourseType::all(),
        ]);
    }

    public function quiz_update(Request $request) {

        $quiz = Quiz::find($request->id);
        $request->validate([
            'course_category' => 'required',
            'course_type' => 'required',
            'quiz_name' => 'required',
            'time_limit' => 'required',
            'quiz_status' => 'required',
            'quiz_privacy' => 'required',
        ], [
            'course_category.required' => 'Please select the course category.',
            'course_type.required' => 'Please select the course type.',
            'quiz_name.required' => 'Please enter a name for the quiz.',
            'time_limit.required' => 'Please set a time limit for the quiz.',
            'quiz_status.required' => 'Please set the status of the quiz.',
            'quiz_privacy.required' => 'Please set the privacy of the quiz.',
        ]);

        $quiz->update([
            'course_id' => $request->course_category,
            'course_type' => $request->course_type,
            'quiz_name' => $request->quiz_name,
            'time_limit' => $request->time_limit,
            'quiz_status' => $request->quiz_status,
            'quiz_privacy' => $request->quiz_privacy,
        ]);

        session()->flash('success', 'Quiz Edited Successfully!');
    }

    public function quiz_delete($id) {
        if (Quiz::find($id)->delete()) {
            return back()->with('dltSuccess', 'Quiz deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function question_edit_modal($id) {
        return view('admin.madals.edit-question', [
            'question' => Question::find($id),
            'choices' => Choice::where('question_id', $id)->get(),
        ]);
    }

    public function question_update(Request $request) {

        $question = Question::find($request->id);
        $quiz_info = Quiz::find($question->quiz_id);
        $choices = $request->choice;
        $db_choices = Choice::where('question_id', $question->id)->get();

        $request->validate([
            'question' => 'required',
            'question_type' => 'required',
            'choice' => 'required',
            'right_answer' => 'required',
            'marks' => 'required',
        ], [
            'question.required' => 'Please enter the question.',
            'question_type.required' => 'Please select the type of the question.',
            'choice.required' => 'Please enter the choices for the question.',
            'right_answer.required' => 'Please set the right answer for the question.',
            'marks.required' => 'Please enter the marks for the question.',
        ]);

        $question->update([
            'question' => $request->question,
            'question_type' => $request->question_type,
            'right_answer' => $request->right_answer,
            'marks' => $request->marks,
        ]);

        foreach ($choices as $key => $choice) {
            $db_choices[$key]->update([
                'choice' => $choice,
                'is_correct' => $request->right_answer == $key + 1 ? 1 : 0,
            ]);
        }

        $question = Question::where('quiz_id', $question->quiz_id);

        $quiz_info->update([
            'total_questions' =>  $question->count(),
            'total_marks' =>  $question->sum('marks'),
        ]);

        session()->flash('success', 'Question Edited Successfully!');
    }

    public function question_delete($id) {
        $question = Question::find($id);
        $quiz_info = Quiz::find($question->quiz_id);
        if ($question->delete()) {
            $quiz_info->update([
                'total_questions' =>  $question->count(),
                'total_marks' =>  $question->sum('marks'),
            ]);
            return back()->with('dltSuccess', 'Question deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }


    public function quiz_report($id) {
        $quiz = Quiz::find($id);
        $reports = QuizScore::where('quiz_id', $id)->get();
        $enrollments = Enroll::all();
        $students = User::all();
        // $enrollment = Enroll::find($report->enrollment_id);
        // $student = User::find($enrollment->user_id);

        if ($quiz->quiz_status == '0') {
            return back()->with('reportErr', 'The quiz has not been published yet!');
        } else {
            return view('admin.quizzes.reports', [
                'quiz' => $quiz,
                'reports' => $reports,
                'enrollments' => $enrollments,
                'students' => $students,
            ]);
        }
    }


    public function quiz_report_edit_modal($id) {
        return view('admin.madals.edit-quiz-report', [
            'report' => QuizScore::find($id),
        ]);
    }

    public function quiz_report_update(Request $request) {
        $report = QuizScore::find($request->id);

        $total_mark = $report->rel_to_quiz->total_marks;

        $validator = Validator::make($request->all(), [
            'score' => 'required|numeric|max:' . $total_mark,
        ], [
            'score.required' => 'Please enter the quiz score.',
            'score.max' => 'The score must not be greater than the total marks (' . $total_mark . ').',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            $report = QuizScore::find($request->id);

            $report->update([
                'score_in_num' => $request->score,
            ]);

            session()->flash('success', 'Quiz Report Updated successfully!');
            return response()->json(['success' => true]);
        }
    }

    public function quiz_report_delete($id) {
        if (QuizScore::find($id)->delete()) {
            return back()->with('success', 'Quiz Report Deleted Successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }
}
