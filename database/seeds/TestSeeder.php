<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $lessons = \App\Models\Lesson::all();

        $lessons->each(function ($lesson, $key) use ($faker) {
            $test = \App\Models\Test::updateOrCreate([
                'lesson_id' => $lesson->getKey(),
            ], [
                'title' => 'Test '.($key + 1),
                'lesson_id' => $lesson->getKey(),
            ]);

            if ($key % 2 == 0) {
                $testQuestion = \App\Models\TestQuestion::create([
                    'text' => $faker->paragraph(2),
                    'type' => \App\Models\TestQuestion::QUESTION_TYPE['MCQ'],
                    'test_id' => $test->getKey(),
                ]);

                $answer = $faker->numberBetween(1, 4);
                for ($i = 1; $i <= 4; $i++) {
                    if($i == $answer){
                        $data = [
                            'text' => $faker->text(10),
                            'is_answer' => 1,
                            'question_id' => $testQuestion->getKey(),
                        ];
                    }else{
                        $data = [
                            'text' => $faker->text(10),
                            'is_answer' => 0,
                            'question_id' => $testQuestion->getKey(),
                        ];
                    }

                    \App\Models\TestQuestionOption::create($data);
                }

                \App\Models\TestQuestion::create([
                    'text' => $faker->paragraph(2),
                    'type' => \App\Models\TestQuestion::QUESTION_TYPE['Reflexive'],
                    'test_id' => $test->getKey(),
                ]);

            } else {
                \App\Models\TestQuestion::create([
                    'text' => $faker->paragraph(2),
                    'type' => \App\Models\TestQuestion::QUESTION_TYPE['Reflexive'],
                    'test_id' => $test->getKey(),
                ]);
            }
        });
    }
}
