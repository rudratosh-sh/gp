<?php

declare(strict_types=1);

namespace App\Orchid\Screens\questionTypeV2;

use App\Models\questionTypeV2;
use App\Orchid\Layouts\questionTypeV2\questionTypeV2ListLayout;
use App\Orchid\Layouts\questionTypeV2\questionTypeV2FiltersLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\Log;

class questionTypeV2ListScreen extends Screen
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
        $questionTypeV2 = questionTypeV2::defaultSort('id', 'desc')->get();
        return [
            'questionTypeV2' => $questionTypeV2,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Question Type Management';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.questionTypeV2.view',
            'platform.systems.questionTypeV2.create',
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
                ->route('platform.systems.questionTypeV2.create')
                ->canSee($this->hasPermission('platform.systems.questionTypeV2.create')),
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
            questionTypeV2FiltersLayout::class,
            questionTypeV2ListLayout::class,
        ];
    }

    /**
     * Save the answer option data.
     *
     * @param Request      $request
     * @param QuestionTYpe $questionType
     */
    public function save(Request $request, questionTypeV2 $questionTypeV2): void
    {
        $questionTypeV2->fill($request->input('questionTypeV2'))->save();

        Toast::info(__('Question Type was saved.'));
    }

    /**
     * Remove the Question Type.
     *
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        questionTypeV2::findOrFail($request->get('id'))->delete();

        Toast::info(__('Question Type was removed'));
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
