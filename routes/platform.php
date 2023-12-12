<?php

declare(strict_types=1);

use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\Clinic\ClinicEditScreen;
use App\Orchid\Screens\Clinic\ClinicListScreen;
use App\Orchid\Screens\Doctor\DoctorEditScreen;
use App\Orchid\Screens\Doctor\DoctorListScreen;
use App\Orchid\Screens\Speciality\SpecialityEditScreen;
use App\Orchid\Screens\Speciality\SpecialityListScreen;
use App\Orchid\Screens\Format\FormatEditScreen;
use App\Orchid\Screens\Format\FormatListScreen;
use App\Orchid\Screens\Questionnaire\QuestionnaireEditScreen;
use App\Orchid\Screens\Questionnaire\QuestionnaireListScreen;
use App\Orchid\Screens\Section\SectionEditScreen;
use App\Orchid\Screens\Section\SectionListScreen;
use App\Orchid\Screens\Question\QuestionEditScreen;
use App\Orchid\Screens\Question\QuestionListScreen;
use App\Orchid\Screens\AnswerOption\AnswerOptionEditScreen;
use App\Orchid\Screens\AnswerOption\AnswerOptionListScreen;
use App\Orchid\Screens\UserResponse\UserResponseEditScreen;
use App\Orchid\Screens\UserResponse\UserResponseListScreen;
use App\Orchid\Screens\Staff\StaffEditScreen;
use App\Orchid\Screens\Staff\StaffListScreen;

use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

//Route::screen('idea', Idea::class, 'platform.screens.idea');
// Platform > System > Clinics > Clinic
Route::screen('clinics/{clinic}/edit', ClinicEditScreen::class)
    ->name('platform.systems.clinics.edit')
    ->breadcrumbs(fn (Trail $trail, $clinic) => $trail
        ->parent('platform.systems.clinics')
        ->push($clinic->name, route('platform.systems.clinics.edit', $clinic)));

// Platform > System > Clinics > Create
Route::screen('clinics/create', ClinicEditScreen::class)
    ->name('platform.systems.clinics.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.clinics')
        ->push(__('Create'), route('platform.systems.clinics.create')));

// Platform > System > Clinics
Route::screen('clinics', ClinicListScreen::class)
    ->name('platform.systems.clinics')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Clinics'), route('platform.systems.clinics')));

// Platform > System > Doctors > Doctor
Route::screen('doctors/{doctor}/edit', DoctorEditScreen::class)
    ->name('platform.systems.doctors.edit')
    ->breadcrumbs(fn (Trail $trail, $doctor) => $trail
        ->parent('platform.systems.doctors')
        ->push($doctor->user->name, route('platform.systems.doctors.edit', $doctor)));

// Platform > System > Doctors > Create
Route::screen('doctors/create', DoctorEditScreen::class)
    ->name('platform.systems.doctors.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.doctors')
        ->push(__('Create'), route('platform.systems.doctors.create')));

// Platform > System > Doctors
Route::screen('doctors', DoctorListScreen::class)
    ->name('platform.systems.doctors')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Doctors'), route('platform.systems.doctors')));

// Platform > System > Specialities > speciality
Route::screen('specialities/{speciality}/edit', SpecialityEditScreen::class)
    ->name('platform.systems.specialities.edit')
    ->breadcrumbs(fn (Trail $trail, $speciality) => $trail
        ->parent('platform.systems.specialities')
        ->push($speciality->name, route('platform.systems.specialities.edit', $speciality)));

// Platform > System > Specialities > Create
Route::screen('specialities/create', SpecialityEditScreen::class)
    ->name('platform.systems.specialities.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.specialities')
        ->push(__('Create'), route('platform.systems.specialities.create')));

// Platform > System > Specialities
Route::screen('specialities', SpecialityListScreen::class)
    ->name('platform.systems.specialities')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Specialities'), route('platform.systems.specialities')));

// Platform > System > Formats > Format
Route::screen('formats/{format}/edit', FormatEditScreen::class)
    ->name('platform.systems.formats.edit')
    ->breadcrumbs(fn (Trail $trail, $format) => $trail
        ->parent('platform.systems.formats')
        ->push($format->name, route('platform.systems.formats.edit', $format)));

// Platform > System > Formats > Create
Route::screen('formats/create', FormatEditScreen::class)
    ->name('platform.systems.formats.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.formats')
        ->push(__('Create'), route('platform.systems.formats.create')));

// Platform > System > Formats
Route::screen('formats', FormatListScreen::class)
    ->name('platform.systems.formats')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Formats'), route('platform.systems.formats')));

// Platform > System > Questionnaires > Questionnaire
Route::screen('questionnaires/{questionnaire}/edit', QuestionnaireEditScreen::class)
    ->name('platform.systems.questionnaires.edit')
    ->breadcrumbs(fn (Trail $trail, $questionnaire) => $trail
        ->parent('platform.systems.questionnaires')
        ->push($questionnaire->name, route('platform.systems.questionnaires.edit', $questionnaire)));

// Platform > System > Questionnaires > Create
Route::screen('questionnaires/create', QuestionnaireEditScreen::class)
    ->name('platform.systems.questionnaires.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.questionnaires')
        ->push(__('Create'), route('platform.systems.questionnaires.create')));

// Platform > System > Questionnaires
Route::screen('questionnaires', QuestionnaireListScreen::class)
    ->name('platform.systems.questionnaires')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Questionnaires'), route('platform.systems.questionnaires')));

// Platform > System > Sections > Section
Route::screen('sections/{section}/edit', SectionEditScreen::class)
    ->name('platform.systems.sections.edit')
    ->breadcrumbs(fn (Trail $trail, $section) => $trail
        ->parent('platform.systems.sections')
        ->push($section->name, route('platform.systems.sections.edit', $section)));

// Platform > System > Sections > Create
Route::screen('sections/create', SectionEditScreen::class)
    ->name('platform.systems.sections.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.sections')
        ->push(__('Create'), route('platform.systems.sections.create')));

// Platform > System > Sections
Route::screen('sections', SectionListScreen::class)
    ->name('platform.systems.sections')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Sections'), route('platform.systems.sections')));

// Platform > System > Questions > Question
Route::screen('questions/{question}/edit', QuestionEditScreen::class)
    ->name('platform.systems.questions.edit')
    ->breadcrumbs(fn (Trail $trail, $question) => $trail
        ->parent('platform.systems.questions')
        ->push($question->question_text, route('platform.systems.questions.edit', $question)));

// Platform > System > Questions > Create
Route::screen('questions/create', QuestionEditScreen::class)
    ->name('platform.systems.questions.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.questions')
        ->push(__('Create'), route('platform.systems.questions.create')));

// Platform > System > Questions
Route::screen('questions', QuestionListScreen::class)
    ->name('platform.systems.questions')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Questions'), route('platform.systems.questions')));

// Platform > System > Answer Options > Answer Option
Route::screen('answerOptions/{answerOption}/edit', AnswerOptionEditScreen::class)
    ->name('platform.systems.answerOptions.edit')
    ->breadcrumbs(fn (Trail $trail, $answerOption) => $trail
        ->parent('platform.systems.answerOptions')
        ->push($answerOption->text, route('platform.systems.answerOptions.edit', $answerOption)));

// Platform > System > Answer Options > Create
Route::screen('answerOptions/create', AnswerOptionEditScreen::class)
    ->name('platform.systems.answerOptions.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.answerOptions')
        ->push(__('Create'), route('platform.systems.answerOptions.create')));

// Platform > System > Answer Options
Route::screen('answerOptions', AnswerOptionListScreen::class)
    ->name('platform.systems.answerOptions')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Answer Options'), route('platform.systems.answerOptions')));

// Platform > System > User Responses > User Response
Route::screen('userResponses/{userResponse}/edit', UserResponseEditScreen::class)
    ->name('platform.systems.userResponses.edit')
    ->breadcrumbs(fn (Trail $trail, $userResponse) => $trail
        ->parent('platform.systems.userResponses')
        ->push($userResponse->id, route('platform.systems.userResponses.edit', $userResponse)));

// Platform > System > User Responses > Create
Route::screen('userResponses/create', UserResponseEditScreen::class)
    ->name('platform.systems.userResponses.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.userResponses')
        ->push(__('Create'), route('platform.systems.userResponses.create')));

// Platform > System > User Responses
Route::screen('userResponses', UserResponseListScreen::class)
    ->name('platform.systems.userResponses')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('User Responses'), route('platform.systems.userResponses')));


// Platform > System > Staffs > Staff
Route::screen('staffs/{staff}/edit', StaffEditScreen::class)
    ->name('platform.systems.staffs.edit')
    ->breadcrumbs(fn (Trail $trail, $staff) => $trail
        ->parent('platform.systems.staffs')
        ->push($staff->user->name, route('platform.systems.staffs.edit', $staff)));

// Platform > System > Staffs > Create
Route::screen('staffs/create', StaffEditScreen::class)
    ->name('platform.systems.staffs.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.staffs')
        ->push(__('Create'), route('platform.systems.staffs.create')));

// Platform > System > Staffs
Route::screen('staffs', StaffListScreen::class)
    ->name('platform.systems.staffs')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Staffs'), route('platform.systems.staffs')));
