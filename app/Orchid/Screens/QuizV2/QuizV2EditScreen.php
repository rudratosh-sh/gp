<?php

declare(strict_types=1);

namespace App\Orchid\Screens\QuizV2;

use App\Models\QuizV2;
use App\Orchid\Layouts\QuizV2\QuizV2EditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;
use App\Orchid\Screens\QuizV2\ClinicDoctorUserListener;


class QuizV2EditScreen extends Screen
{
    public $target = 'quizzes';
    protected $source = 'quizzes_v2';


    /**
     * @var QuizV2
     */
    public $quizV2;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Request $request, ?QuizV2 $quizV2): array
    {
        $id = $request->route('quizV2'); // Retrieve the 'quizV2' parameter from the route

        if ($id &&  $id->quiz_id) {
            $this->quizV2 = QuizV2::find($id->quiz_id);
        } else {
            $this->quizV2 = $quizV2 ?? new QuizV2();
        }
        return [
            'quizV2' => $this->quizV2,
        ];
    }


    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->quizV2->exists ? 'Edit Quiz' : 'Create Quiz';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Update quiz information';
    }

    public function permission(): ?iterable
    {
        return [
            (is_object($this->quizV2) && $this->quizV2->exists)
                ? 'platform.systems.quizV2.edit'
                : 'platform.systems.quizV2.create',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Once the quiz is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->quizV2->exists)
                ->can('platform.systems.quizV2.delete'),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save')
                ->can('platform.systems.quizV2.edit'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(QuizV2EditLayout::class)
                ->title(__('Quiz Information'))
                ->description(__('Update quiz details here.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::PRIMARY)
                        ->icon('bs.check-circle')
                        ->canSee($this->quizV2->exists)
                        ->can('platform.systems.quizV2.edit')
                        ->method('save')
                ),
            ClinicDoctorUserListener::class,
        ];
    }

    /**
     * Save the quiz data.
     *
     * @param QuizV2  $quiz
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(QuizV2 $quiz, Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'quiz.quiz_name' => 'required|string|max:255',
            'quiz.clinic_id' => 'exists:clinics,id',
            'quiz.doctor_id' => 'exists:doctors,user_id',
            'quiz.user_id' => 'array', // Assuming it's an array of user IDs
        ]);

        // Fill basic quiz information
        $quiz->fill($data['quiz']);
        $quiz->save();

        // Attach clinic, doctor, and users to the quiz using relationships
        $quiz->clinicQuizzes()->updateOrCreate(['clinic_id' => $data['quiz']['clinic_id']]);
        $quiz->doctorQuizzes()->updateOrCreate(['doctor_id' => $data['quiz']['doctor_id']]);

        // Sync users
        $quiz->users()->sync($data['quiz']['user_id']);

        Toast::info(__('Quiz was saved.'));

        return redirect()->route('platform.systems.quizV2');
    }

    /**
     * Remove the quiz.
     *
     * @param QuizV2 $quiz
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(QuizV2 $quiz)
    {
        $quiz->delete();

        Toast::info(__('Quiz was removed'));

        return redirect()->route('platform.systems.quizV2');
    }
}
