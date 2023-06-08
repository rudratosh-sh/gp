<?php

declare(strict_types=1);

namespace App\Orchid\Screens\UserResponse;

use App\Models\UserResponse;
use App\Orchid\Layouts\UserResponse\UserResponseEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;
use Orchid\Screen\Fields\Input;

class UserResponseEditScreen extends Screen
{
    /**
     * @var UserResponse
     */
    public $userResponse;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(UserResponse $userResponse): array
    {
        $this->userResponse = $userResponse;

        return [
            'userResponse' => $this->userResponse,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->userResponse->exists ? 'Edit User Response' : 'Create User Response';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Update user response information';
    }

    public function permission(): ?iterable
    {
        return [
            ($this->userResponse && $this->userResponse->exists)
                ? 'platform.systems.userResponses.edit'
                : 'platform.systems.userResponses.create',
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
                ->confirm(__('Once the user response is deleted, all related data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->userResponse->exists)
                ->can('platform.systems.userResponses.delete'),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save')
                ->can('platform.systems.userResponses.edit'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(UserResponseEditLayout::class)
                ->title(__('User Response Information'))
                ->description(__('Update user response details here.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::PRIMARY)
                        ->icon('bs.check-circle')
                        ->canSee($this->userResponse->exists)
                        ->can('platform.systems.userResponses.edit')
                        ->method('save')
                ),

            // Add more layout elements as needed
        ];
    }

    /**
     * Save the user response data.
     *
     * @param UserResponse $userResponse
     * @param Request      $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(UserResponse $userResponse, Request $request)
    { 
        $userResponse->fill($request->get('userResponse'));

        // Save the user response
        $userResponse->save();

        Toast::info(__('User response was saved.'));

        return redirect()->route('platform.systems.userResponses');
    }

    /**
     * Remove the user response.
     *
     * @param UserResponse $userResponse
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(UserResponse $userResponse)
    {
        $userResponse->delete();

        Toast::info(__('User response was removed'));

        return redirect()->route('platform.systems.userResponses');
    }
}
