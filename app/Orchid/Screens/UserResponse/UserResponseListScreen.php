<?php

declare(strict_types=1);

namespace App\Orchid\Screens\UserResponse;

use App\Models\UserResponse;
use App\Orchid\Layouts\UserResponse\UserResponseListLayout;
use App\Orchid\Layouts\UserResponse\UserResponseFiltersLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UserResponseListScreen extends Screen
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
        return [
            'userResponses' => UserResponse::defaultSort('id', 'desc')->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'User Response Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all user responses.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.userResponses.view',
            'platform.systems.userResponses.create',
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
                ->route('platform.systems.userResponses.create')
                ->canSee($this->hasPermission('platform.systems.userResponses.create')),
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
            UserResponseFiltersLayout::class,
            UserResponseListLayout::class,
        ];
    }

    /**
     * Save the user response data.
     *
     * @param Request       $request
     * @param UserResponse  $userResponse
     */
    public function save(Request $request, UserResponse $userResponse): void
    {
        $userResponse->fill($request->input('userResponses'))->save();

        Toast::info(__('User response was saved.'));
    }

    /**
     * Remove the user response.
     *
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        UserResponse::findOrFail($request->get('id'))->delete();

        Toast::info(__('User response was removed'));
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
