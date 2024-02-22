<?php
declare(strict_types=1);

namespace App\Orchid\Screens\QuestionV2;

use App\Models\QuestionV2;
use App\Orchid\Layouts\QuestionV2\QuestionV2ListLayout;
use App\Orchid\Layouts\QuestionV2\QuestionV2FiltersLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class QuestionV2ListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Request $request
     *
     * @return array
     */
    public function query(Request $request): array
    {
        $questionV2 = QuestionV2::defaultSort('question_id', 'desc')->get();
        return [
            'questionV2' => $questionV2,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'QuestionV2 Management';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.questionV2.view',
            'platform.systems.questionV2.create',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('bs.plus-circle')
                ->route('platform.systems.questionV2.create')
                ->canSee($this->hasPermission('platform.systems.questionV2.create')),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            QuestionV2FiltersLayout::class,
            QuestionV2ListLayout::class,
        ];
    }

    /**
     * Save the answer option data.
     *
     * @param Request  $request
     * @param QuestionV2 $questionV2
     */
    public function save(Request $request, QuestionV2 $questionV2): void
    {
        $questionV2->fill($request->input('questionV2'))->save();

        Toast::info(__('QuestionV2 was saved.'));
    }

    /**
     * Remove the QuestionV2.
     *
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        QuestionV2::findOrFail($request->get('id'))->delete();

        Toast::info(__('QuestionV2 was removed'));
    }

    /**
     * Check if a specific permission exists for this screen.
     *
     * @param string $permission
     *
     * @return bool
     */
    private function hasPermission(string $permission): bool
    {
        return collect($this->permission())->contains($permission);
    }
}
