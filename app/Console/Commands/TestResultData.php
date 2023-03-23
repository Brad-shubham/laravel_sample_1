<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\ParagraphQuestion;
use App\Models\ParagraphQuestionsAnswer;
use App\Models\TestAnswer;
use App\Models\TestQuestion;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Factory;
use Faker\Generator as Faker;

class TestResultData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test_result:data';

    /**
     * @var Faker
     */
    public $faker;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the dummy data for the test results.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Faker $faker)
    {
        parent::__construct();
        $this->faker = $faker;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("Adding test results data...");

        $this->testResultData();
        $this->paragraphAnswerData();

        $this->info('Data creation finished.');
        return 0;
    }

    public function testResultData()
    {
        $tests = \App\Models\Test::with('questions', 'questions.options')->get()->toArray();

        foreach ($tests as $test) {
            $questions = $test['questions'];
            $submittedAnswers = ['test_id' => $test['id'], 'questions' => []];
            $total_score = 0;
            foreach ($questions as $question) {
                if ($question['type'] === TestQuestion::QUESTION_TYPE['MCQ']) {
                    $options = $question['options'];
                    $random_option = array_rand($options, 1);
                    $marks = ($options[$random_option]['is_answer']) ? 10 : 0;
                    $total_score = $total_score + $marks;

                    array_push($submittedAnswers['questions'], [
                            'type' => $question['type'],
                            'answer' => $options[$random_option]['id'],
                            'score' => $marks,
                            'comments' => null,
                        ]
                    );
                } else {
                    array_push($submittedAnswers['questions'], [
                            'type' => $question['type'],
                            'answer' => $this->faker->paragraphs(10, true),
                            'score' => 0,
                            'comments' => null,
                        ]
                    );
                }
            }
            $users = User::where('user_type', User::USER_TYPE['student'])->get();
            foreach ($users as $user) {
                $percentage = ($total_score / (count($questions) * 10)) * 100;

                $testResult = \App\Models\TestResult::query()
                    ->updateOrCreate([
                        'student_id' => $user->id,
                        'test_id' => $test['id']
                    ], [
                        'teacher_id' => null,
                        'total_marks' => $total_score,
                        'percentage' => $percentage,
                        'total_questions' => count($questions),
                        'status' => \App\Models\TestResult::STATUS['pending'],
                    ]);

                TestAnswer::query()
                    ->updateOrCreate(['test_result_id' => $testResult->getKey(),], [
                        'test_result_id' => $testResult->id,
                        'submitted_answers' => $submittedAnswers,
                        'original_answers' => $test,
                    ]);
            }
        }
    }

    public function paragraphAnswerData()
    {
        $paragraphQuestions = ParagraphQuestion::with('paragraph')->has('paragraph')->get();

        $paragraphQuestions->each(function ($question) {
            $students = User::where('user_type', User::USER_TYPE['student'])->get();

            $students->each(function ($student) use ($question) {
                ParagraphQuestionsAnswer::updateOrCreate([
                    'user_id' => $student->getKey(),
                    'question_id' => $question->getKey(),
                ], [
                    'user_id' => $student->getKey(),
                    'question_id' => $question->getKey(),
                    'answer' => $this->faker->paragraphs(10, true),
                ]);
            });
        });
    }
}
