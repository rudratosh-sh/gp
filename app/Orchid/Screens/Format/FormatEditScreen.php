<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Format;

use App\Models\Format;
use App\Orchid\Layouts\Format\FormatEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;

class FormatEditScreen extends Screen
{
    /**
     * @var Format
     */
    public $format;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(?Format $format): array
    {
        $this->format = $format ?? new Format();

        return [
            'format' => $this->format,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->format->exists ? 'Edit Format' : 'Create Format';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Update format information';
    }

    public function permission(): ?iterable
    {
        return [
            ($this->format && $this->format->exists)
                ? 'platform.systems.formats.edit'
                : 'platform.systems.formats.create',
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
                ->confirm(__('Once the format is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->format->exists)
                ->can('platform.systems.formats.delete'),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save')
                ->can('platform.systems.formats.edit'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(FormatEditLayout::class)
                ->title(__('Format Information'))
                ->description(__('Update format details here.')),
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Format $format, Request $request)
    {
        $data = $request->validate([
            'format.name' => 'required|string|max:255',
            'format.description' => 'required|string|max:255',
            // Add validation rules for other fields here
        ]);

        $format->fill($data['format']);

        $format->save();

        Toast::info(__('Format was saved.'));

        return redirect()->route('platform.systems.formats');
    }



    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Format $format)
    {
        $format->delete();

        Toast::info(__('Format was removed'));

        return redirect()->route('platform.systems.formats');
    }
}
