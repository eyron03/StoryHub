<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\FlipbookController;
use App\Http\Controllers\ForgotPassword;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizResultController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\StorybookController;
use App\Http\Controllers\TeachersController;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Route;
use rudrarajiv\flipbooklaravel\Flipbook;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('index');
})->middleware('maintenance')->name('index');

// Route::get('/admin/parent', function () {
//     return view('admin.parentDashboard');
// });
    Route::get('/maintenance',[MaintenanceController::class, 'maintenance']);


    Route::get('/login', action: [LoginController::class, 'LoginIndex'])->name(name: 'LoginIndex');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/parent/register', [ParentsController::class, 'register'])->name('parents.register.submit');
    Route::get('/admin/register', [AdminController::class, 'showRegister'])->name('admin.register');
    Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register.submit');
    Route::get('/admin/{flipbook}/create-quiz', [FlipbookController::class, 'createQuiz'])->name('admin.createQuiz');
    Route::post('/admin/{flipbook}/store-quiz', [FlipbookController::class, 'storeQuiz'])->name('admin.storeQuiz');
    Route::middleware(['parent'])->group(function(){
      Route::post('/parent/logout', [ParentsController::class, 'logout'])->name('logout');

    Route::get('/parent/dashboard', [LoginController::class, 'Pdashboard'])->name('parents.dashboard');
    Route::get('/parent/kids', [ParentsController::class, 'MyKids'])->name('parent.MyKids');
    Route::post('/parent/store', [ChildrenController::class, 'store'])->name('children.store');
    Route::get('/parent/child/{id}/edit', [ChildrenController::class, 'editChild'])->name('children.edit');
    Route::post('/children/update', [ChildrenController::class, 'updateChild'])->name('child.update');
    Route::delete('/children/{id}', [ChildrenController::class, 'destroy'])->name('children.destroy');
    Route::get('/parent/storytime',[ParentsController::class,'storytime'])->name('parent.storytime');
    Route::get('/parent/reports',[QuizResultController::class,'reports'])->name('parent.reports');
    Route::get('/parent/progress', [QuizResultController::class, 'progress'])->name('parent.progress');
    Route::get('/parent/settings', [ParentsController::class,'settings'])->name('parent.settings');

    Route::put('/parent/update', [ParentsController::class, 'update'])->name('parent.update');

    Route::post('/parent/change-password', [ParentsController::class, 'changePassword'])->name('parent.changePassword');
    Route::get('/parent/storybook/{childId}',[ParentsController::class,'storybook'])->name('parent.storybook');
    Route::get('/parent/storybook/bookshow/{id}/{childId}', [ParentsController::class, 'bookshow'])->name('parent.bookshow');
    Route::get('/parent/storybook/bookshowAudio/{id}/{childId}', [ParentsController::class, 'bookshowAudio'])->name('parent.bookshowAudio');
    Route::get('/parent/storybook/bookshow/quiz/{id}/{childId}', [QuizController::class, 'quizshow'])->name('parent.quizshow');
    Route::post('/parent/storybook/bookshow/quiz/child/{id}/{childId}', [QuizController::class, 'submitQuiz'])->name('quiz.submit');

    Route::get('/parent/storybook/quizResults/{id}/{childId}/{quizResultId}', [QuizResultController::class, 'showResults'])->name('parent.quizResult');
});

    Route::get('/admin/parent/{id}/edit', [AdminController::class, 'editParent'])->name('parent.edit');

    Route::put('/admin/parent/update/{id}', [AdminController::class, 'updateParent'])->name('admin.parent.update');
    Route::get('/admin/analytics',[AdminController::class,'Analytics'])->name('admin.Analytics');

    Route::get('/admin/edit/quiz/{id}', [FlipbookController::class, 'editQuiz'])->name('admin.editQuiz');
    Route::put('/admin/edit/quiz/update/{id}',[FlipbookController::class,'updateQuiz'])->name('admin.updateQuiz');
    Route::middleware([ 'admin'])->group(function () {

    Route::get('/admin/dashboard', [LoginController::class, 'Adashboard'])->name('admin.dashboard');

    Route::get('/admin/parent', [AdminController::class, 'parentDashboard'])->name('admin.parentDashboard');
    Route::get('/admin/children', [AdminController::class, 'childrenDashboard'])->name('admin.childrenDashboard');
    Route::get('/admin/parent/{id}', [AdminController::class, 'viewParent'])->name('parent.view');

    Route::delete('/admin/parent/{id}', [AdminController::class, 'destroyParent'])->name('parent.destroy');

    Route::get('/admin/child/{id}', [AdminController::class, 'viewChild'])->name('child.view');
    Route::get('/admin/child/{id}/edit', [AdminController::class, 'editChild'])->name('child.edit');
    Route::post('/children/update', [AdminController::class, 'updateChild'])->name('child.update');
    Route::delete('/admin/children/{id}', [AdminController::class, 'destroyChildren'])->name('admin.children.destroy');
    Route::get('/admin/reports',[AdminController::class,'reports'])->name('admin.reports');
    Route::get('/admin/progress',[AdminController::class,'progress'])->name('admin.progress');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('/admin/books', [FlipBookController::class, 'index'])->name('flipbook.index');
    Route::get('admin/create', [FlipBookController::class, 'create'])->name('flipbook.create');
    Route::post('/flipbookstore', [FlipBookController::class, 'store'])->name('flipbookstore');

    Route::get('/{id}/edit', [FlipBookController::class, 'edit'])->name('editbook');
    Route::put('/audioBook/{id}', [FlipBookController::class, 'update'])->name('flipbook.update');
    Route::delete('/{id}/edit', [FlipBookController::class, 'destroy'])->name('flipbook.destroy');


     Route::get('/admin/teacher',[AdminController::class,'teachersDashboard'])->name('admin.teacherDashboard');

     Route::post('/admin/teacher', [AdminController::class, 'storeTeacher'])->name('admin.addTeacher');
     Route::get('/admin/teacher/{id}', [AdminController::class, 'showTeacher'])->name('admin.showTeacher');

     Route::put('/teacher/{id}', [AdminController::class, 'updateTeacher'])->name('admin.updateTeacher');

     Route::delete('/teacher/{id}', [AdminController::class, 'destroyTeacher'])->name('admin.deleteTeacher');
     Route::get('/admin/settings',[AdminController::class,'settings'])->name('admin.settings');

     Route::post('/admin/change-password', [AdminController::class, 'changePassword'])->name('admin.change.password');

     Route::put('/admin/change-email', [AdminController::class, 'changeEmail'])->name('admin.change.email');
     Route::get('/admin/logs',[AdminController::class,'logReports'])->name('admin.Logs');

});

    Route::get('/{id}', [FlipBookController::class, 'show'])->name('showbook');
    Route::get('/audio/{id}', [FlipBookController::class, 'AudioBook'])->name('AudioBook');
    Route::get('/admin/audioBook', action: [FlipBookController::class, 'indexAudioBook'])->name('flipbook.indexAudioBook');
    Route::get('/quiz/{id}', [FlipBookController::class, 'showquiz'])->name('showquiz');

    Route::middleware(['teacher'])->group(function(){

    Route::get('/teacher/dashboard',[TeachersController::class,'index'])->name('teachers.dashboard');
    Route::get('/teacher/parent',[TeachersController::class,'parent'])->name('teachers.parent');

    Route::put('/teacher/parent/update/{id}', [TeachersController::class, 'updateParent'])->name('teacher.parent.update');

    Route::get('/teacher/pupils',[TeachersController::class,'pupils'])->name('teachers.pupils');
    Route::post('/teacher/store', [TeachersController::class, 'storePupil'])->name('pupils.store');
    Route::get('/teacher/books',[TeachersController::class,'books'])->name('teacher.books');
    Route::get('/teacher/reports',[TeachersController::class,'reports'])->name('teacher.reports');
    Route::get('/teacher/progressReports', [TeachersController::class, 'showProgress'])->name('teacher.progress');

    Route::delete('/teacher/remove-from-gradelevel/{id}', [TeachersController::class, 'removeFromGradeLevel'])->name('teacher.removeFromGradeLevel');
    Route::post('/teacher/logout',[TeachersController::class,'logout'])->name('teacher.logout');
    Route::get('/teacher/settings', [TeachersController::class, 'settings'])->name('teacher.settings');
    Route::get('/teacher/pupils/{id}',[TeachersController::class,'editPupil'])->name('teacher.editPupil');
    Route::post('/teacher/remove-all-from-grade-levels', action: [TeachersController::class, 'removeAllFromGradeLevels'])
    ->name('children.removeAllFromGradeLevels');
    Route::post('/teacher/pupils/update',[TeachersController::class,'updatePupil'])->name('teacher.updatePupil');
    Route::post('/teacher/update', [TeachersController::class, 'updateInfo'])->name('teacher.updateInfo');
    Route::post('/teacher/change-password', [TeachersController::class, 'changePassword'])->name('teacher.changePassword');
    Route::get('/teacher/showbook/{id}',[TeachersController::class,'showbook'])->name('teacher.showbook');
    Route::get('/teacher/showquiz/{id}',[TeachersController::class,'teacherShowquiz'])->name('teacher.showquiz');
    });


Route::post('password/email', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset', function () {
    return view('auth.passwords.email');
})->name('password.request');


Route::post('password/email', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('password/reset/{token}', function ($token) {
    return view('auth.password.reset', ['token' => $token]);
})->name('password.reset');

// Route to handle the actual password reset
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
