<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\CourseCategory;
use App\Models\CourseType;
use App\Models\Enroll;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizScore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentQuizController extends Controller {

    public function index() {
        $enrollment = Enroll::where('user_id', Auth::id());
        // echo $enrollment->exists();
        if (Enroll::where('user_id', Auth::id())->exists()) {
            $has_participated = QuizScore::where('enrollment_id', $enrollment->first()->id);

            return view('frontend.quiz.index', [
                'course_categories' => CourseCategory::all(),
                'course_types' => CourseType::all(),
                'quizzes' => Quiz::all(),
                'has_participated' => $has_participated,
            ]);
        } else {
            return back()->with('participationError', 'You have to enroll to a course first in order to participate in quizzes.');
        }
    }

    public function quiz_participate($quiz_id) {
        $quiz_info = Quiz::find($quiz_id);
        $questions = Question::inRandomOrder()->where('quiz_id', $quiz_id)->take(10)->get();
        $choices = Choice::all();

        session()->flash('startQuiz', "You have " . $quiz_info->time_limit . " mins for this quiz.");

        return view('frontend.quiz.participate', [
            'quiz_info' => $quiz_info,
            'questions' => $questions,
            'choices' => $choices,
        ]);
    }

    public function quiz_submit(Request $request, $quiz_id) {

        $quiz = Quiz::find($quiz_id);
        $enroll_id = Enroll::where('course_category', $quiz->course_id)->where('course_type', $quiz->course_type)->where('user_id', Auth::id())->first()->id;
        $questions = json_decode($request->questions, true);
        // $questions = Question::where('quiz_id', $quiz_id)->get();
        $answers = $request->all();

        // foreach ($answers as $key => $answer) {
        //     $q_id = Choice::find($answer)->rel_to_question->question_id;
        //     $questions[$key] = Question::find($q_id);
        // };

        $score = 0;
        // print_r($answers);
        // die();
        foreach ($questions as $key => $question) {

            // $request->validate([
            //     'ans' . $key + 1 => 'required',
            // ]);

            $choices = Choice::where('question_id', $question['id'])->where('is_correct', 1)->get();
            foreach ($choices as $choice) {
                if (array_key_exists('ans' . $key + 1, $answers)) {
                    if ($answers['ans' . $key + 1] == $choice->id) {
                        $score += $question['marks'];
                    }
                } else {
                    $score += 0;
                }
            }
        }

        $score_in_per = round(($score * 100) / $quiz->total_marks);

        if (QuizScore::where('enrollment_id', $enroll_id)->where('quiz_id', $quiz_id)->exists()) {
            QuizScore::where('enrollment_id', $enroll_id)->where('quiz_id', $quiz_id)->update([
                'score_in_num' => $score,
                'score_in_percentage' => $score_in_per,
            ]);
        } else {
            QuizScore::insert([
                'enrollment_id' => $enroll_id,
                'quiz_id' => $quiz_id,
                'score_in_num' => $score,
                'score_in_percentage' => $score_in_per,
                'created_at' => Carbon::now()
            ]);
        }


        // print_r($request->all());
        return redirect()->route('admin.quiz.list')->with('finishedQuiz', "Quiz answers submitted successfully!");
    }

    public function quiz_view_report($quiz_id) {
        $quiz = Quiz::find($quiz_id);
        $enroll = Enroll::where('course_category', $quiz->course_id)->where('course_type', $quiz->course_type)->where('user_id', Auth::id())->first();
        $report = QuizScore::where('quiz_id', $quiz_id)->where('enrollment_id', $enroll->id)->first();

        $isLow = (($report->score_in_num * 100) / $quiz->total_marks) < 60;
        if ($isLow) {
            return ' <div class="row">
                            <div class="col-6 text-center">
                               <p class="fs-6"> <b>Student Name: </b>' . $enroll->user->name . '</p>
                            </div>
                            <div class="col-6 text-center">
                                <p class="fs-6"><b>Quiz Name: </b>' . $quiz->quiz_name . '</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-center">
                                <p class="fs-6 text-primary"> <b>Total Marks: ' . $quiz->total_marks . ' </b></p>
                            </div>
                            <div class="col-6 text-center">
                                <p class="fs-6"><b class="text-danger">Obtained Marks: ' . $report->score_in_num . '(' . round(($report->score_in_num * 100) / $quiz->total_marks) . '%)</b></p>
                            </div>
                        </div>';
        } else {
            return ' <div class="row">
                            <div class="col-6 text-center">
                               <p class="fs-6"> <b>Student Name: </b>' . $enroll->user->name . '</p>
                            </div>
                            <div class="col-6 text-center">
                                <p class="fs-6"><b>Quiz Name: </b>' . $quiz->quiz_name . '</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-center">
                                <p class="fs-6 text-primary"> <b>Total Marks: ' . $quiz->total_marks . ' </b></p>
                            </div>
                            <div class="col-6 text-center">
                                <p class="fs-6"><b class="text-success">Obtained Marks: ' . $report->score_in_num . '(' . round(($report->score_in_num * 100) / $quiz->total_marks) . '%)</b></p>
                            </div>
                        </div>';
        }

        // $enroll_id = Enroll::where('user_id', Auth::id())->first()->id;
        // $quiz = Quiz::find($quiz_id);
        // $questions = Question::where('quiz_id', $quiz_id)->get();
        // $answers = $request->all();

        // $score = 0;
        // // print_r($answers);
        // // die();
        // foreach ($questions as $key => $question) {

        //     // $request->validate([
        //     //     'ans' . $key + 1 => 'required',
        //     // ]);

        //     $choices = Choice::where('question_id', $question->id)->where('is_correct', 1)->get();
        //     foreach ($choices as $choice) {
        //         if (array_key_exists('ans' . $key + 1, $answers)) {
        //             if ($answers['ans' . $key + 1] == $choice->id) {
        //                 $score += $question->marks;
        //             }
        //         } else {
        //             $score += 0;
        //         }
        //     }
        // }

        // QuizScore::insert([
        //     'enrollment_id' => $enroll_id,
        //     'quiz_id' => $quiz_id,
        //     'score_in_num' => $score,
        //     'created_at' => Carbon::now()
        // ]);
        // // print_r($request->all());
        // return redirect()->route('admin.quiz.list')->with('finishedQuiz', "Quiz answers submitted successfully!");
    }
}
