<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make('Get Started')
                ->icon('bs.book')
                ->title('Navigation')
                ->route(config('platform.index')),

            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access Controls')),

            Menu::make(__('Roles'))
                ->icon('bs.lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),

            // Clinic menu item
            Menu::make(__('Clinics'))
                ->icon('bs.building')
                ->route('platform.systems.clinics')
                ->permission('platform.systems.clinics.view')
                ->title(__('Healthcare Modules')),

            // Doctor menu item
            Menu::make(__('Doctors'))
                ->icon('bs.building')
                ->route('platform.systems.doctors')
                ->permission('platform.systems.doctors.view'),

            // Staff menu item
            Menu::make(__('Staffs'))
                ->icon('bs.building')
                ->route('platform.systems.staffs')
                ->permission('platform.systems.staffs.view'),

            // Speciality menu item
            Menu::make(__('Specialities'))
                ->icon('bs.building')
                ->route('platform.systems.specialities')
                ->permission('platform.systems.specialities.view')
                ->divider(),

            // // Format menu item
            // Menu::make(__('Formats'))
            //     ->icon('bs.building')
            //     ->route('platform.systems.formats')
            //     ->title(__('Questionnaire Modules'))
            //     ->permission('platform.systems.formats.view'),

            // // Questionnaire menu item
            // Menu::make(__('Questionnaires'))
            //     ->icon('bs.building')
            //     ->route('platform.systems.questionnaires')
            //     ->permission('platform.systems.questionnaires.view'),

            // // Section menu item
            // Menu::make(__('Sections'))
            //     ->icon('bs.building')
            //     ->route('platform.systems.sections')
            //     ->permission('platform.systems.sections.view'),

            // // Question menu item
            // Menu::make(__('Questions'))
            //     ->icon('bs.building')
            //     ->route('platform.systems.questions')
            //     ->permission('platform.systems.questions.view'),

            // // Answer option menu item
            // Menu::make(__('Answer Options'))
            //     ->icon('bs.building')
            //     ->route('platform.systems.answerOptions')
            //     ->permission('platform.systems.answerOptions.view'),

            // // User response menu item
            // Menu::make(__('User Responses'))
            //     ->icon('bs.building')
            //     ->route('platform.systems.userResponses')
            //     ->permission('platform.systems.userResponses.view'),

            // Questionnaire menu item
            Menu::make(__('Question Type V2'))
                ->icon('bs.building')
                ->route('platform.systems.questionTypeV2')
                ->permission('platform.systems.questionTypeV2.view'),

            // Quiz menu item
            Menu::make(__('Quiz V2'))
                ->icon('bs.building')
                ->route('platform.systems.quizV2')
                ->permission('platform.systems.quizV2.view'),

                Menu::make(__('Question V2'))
                ->icon('bs.building')
                ->route('platform.systems.questionV2')
                ->permission('platform.systems.questionV2.view'),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),

            // Clinic permissions
            ItemPermission::group(__('Clinics'))
                ->addPermission('platform.systems.clinics.view', __('View Clinics'))
                ->addPermission('platform.systems.clinics.create', __('Create Clinics'))
                ->addPermission('platform.systems.clinics.edit', __('Edit Clinics'))
                ->addPermission('platform.systems.clinics.delete', __('Delete Clinics')),

            // Doctor permissions
            ItemPermission::group(__('Doctors'))
                ->addPermission('platform.systems.doctors.view', __('View Doctors'))
                ->addPermission('platform.systems.doctors.create', __('Create Doctors'))
                ->addPermission('platform.systems.doctors.edit', __('Edit Doctors'))
                ->addPermission('platform.systems.doctors.delete', __('Delete Doctors')),

            // Staff permissions
            ItemPermission::group(__('Staffs'))
                ->addPermission('platform.systems.staffs.view', __('View Staffs'))
                ->addPermission('platform.systems.staffs.create', __('Create Staffs'))
                ->addPermission('platform.systems.staffs.edit', __('Edit Staffs'))
                ->addPermission('platform.systems.staffs.delete', __('Delete Staffs')),

            // Speciality permissions
            ItemPermission::group(__('Specialities'))
                ->addPermission('platform.systems.specialities.view', __('View Specialities'))
                ->addPermission('platform.systems.specialities.create', __('Create Specialities'))
                ->addPermission('platform.systems.specialities.edit', __('Edit Specialities'))
                ->addPermission('platform.systems.specialities.delete', __('Delete Specialities')),

            // Format permissions
            ItemPermission::group(__('Formats'))
                ->addPermission('platform.systems.formats.view', __('View Formats'))
                ->addPermission('platform.systems.formats.create', __('Create Formats'))
                ->addPermission('platform.systems.formats.edit', __('Edit Formats'))
                ->addPermission('platform.systems.formats.delete', __('Delete Formats')),

            // Questionnaire permissions
            ItemPermission::group(__('Questionnaires'))
                ->addPermission('platform.systems.questionnaires.view', __('View Questionnaires'))
                ->addPermission('platform.systems.questionnaires.create', __('Create Questionnaires'))
                ->addPermission('platform.systems.questionnaires.edit', __('Edit Questionnaires'))
                ->addPermission('platform.systems.questionnaires.delete', __('Delete Questionnaires')),

            // Section permissions
            ItemPermission::group(__('Sections'))
                ->addPermission('platform.systems.sections.view', __('View Sections'))
                ->addPermission('platform.systems.sections.create', __('Create Sections'))
                ->addPermission('platform.systems.sections.edit', __('Edit Sections'))
                ->addPermission('platform.systems.sections.delete', __('Delete Sections')),

            // Question permissions
            ItemPermission::group(__('Questions'))
                ->addPermission('platform.systems.questions.view', __('View Questions'))
                ->addPermission('platform.systems.questions.create', __('Create Questions'))
                ->addPermission('platform.systems.questions.edit', __('Edit Questions'))
                ->addPermission('platform.systems.questions.delete', __('Delete Questions')),

            // Answer option permissions
            ItemPermission::group(__('Answer Options'))
                ->addPermission('platform.systems.answerOptions.view', __('View Answer Options'))
                ->addPermission('platform.systems.answerOptions.create', __('Create Answer Options'))
                ->addPermission('platform.systems.answerOptions.edit', __('Edit Answer Options'))
                ->addPermission('platform.systems.answerOptions.delete', __('Delete Answer Options')),

            // User response permissions
            ItemPermission::group(__('User Responses'))
                ->addPermission('platform.systems.userResponses.view', __('View User Responses'))
                ->addPermission('platform.systems.userResponses.create', __('Create User Responses'))
                ->addPermission('platform.systems.userResponses.edit', __('Edit User Responses'))
                ->addPermission('platform.systems.userResponses.delete', __('Delete User Responses')),

            // Questionnaire permissions
            ItemPermission::group(__('Question Type'))
                ->addPermission('platform.systems.questionTypeV2.view', __('View Question Type'))
                ->addPermission('platform.systems.questionTypeV2.create', __('Create Question Type'))
                ->addPermission('platform.systems.questionTypeV2.edit', __('Edit Question Type'))
                ->addPermission('platform.systems.questionTypeV2.delete', __('Delete Question Type')),

            // Questionnaire permissions
            ItemPermission::group(__('Quiz'))
                ->addPermission('platform.systems.quizV2.view', __('View Quiz'))
                ->addPermission('platform.systems.quizV2.create', __('Create Quiz'))
                ->addPermission('platform.systems.quizV2.edit', __('Edit Quiz'))
                ->addPermission('platform.systems.quizV2.delete', __('Delete Quiz')),

            // Question v2 permissions
            ItemPermission::group(__('Questions V2'))
                ->addPermission('platform.systems.questionV2.view', __('View questionV2'))
                ->addPermission('platform.systems.questionV2.create', __('Create questionV2'))
                ->addPermission('platform.systems.questionV2.edit', __('Edit questionV2'))
                ->addPermission('platform.systems.questionV2.delete', __('Delete questionV2'))

        ];
    }
}
