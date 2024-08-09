<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\site\AuthController;
use App\Http\Controllers\site\AccountController;
use App\Http\Controllers\site\SubjectController;
use App\Http\Controllers\site\LanguageController;
use App\Http\Controllers\site\LandingItemController;
use App\Http\Controllers\site\UserController;
use App\Http\Controllers\site\TransactionController;
use App\Http\Controllers\site\CourseController;
use App\Http\Controllers\site\LectureController;
use App\Http\Controllers\site\QuestionController;
use App\Http\Controllers\site\AnalysisController;
use App\Http\Controllers\site\LogController;
use App\Http\Controllers\site\SettingController;
use App\Http\Controllers\site\TeacherTransactionController;
use App\Http\Controllers\site\DatabaseController;
use App\Http\Controllers\site\FreeUsersController;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\LandingItem;

Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'ar', 'he'])) {
        Session::put('applocale', 'en');
    }
 
    Session::put('applocale', $locale);

    return Redirect::back();
})->name('locale.change');



Route::group(['middleware' => 'language' ],function(){


    Route::get('/', function () {
        
        $landingItems = LandingItem::where('status', 'active')
            ->where('locale', App::currentLocale())
            ->orderBy('order')
            ->get();

        return view('dashboard', compact('landingItems'));
    })->name('dashboard');
    
    Route::get('login', function() {
        return view('auth.login');
    })->name('login.show');
    Route::get('register', function() {
        return view('auth.register');
    })->name('register.show');
    Route::get('register-success', function() {
        return view('auth.register-success');
    })->name('register-success.show');
    Route::get('email-verify-required', function() {
        return view('auth.email-verify-required');
    })->name('email-verify-required.show');
    Route::get('phone-verify-required', function() {
        return view('auth.phone-verify-required');
    })->name('phone-verify-required.show');
    Route::get('reset-password-form', function() {
        return view('auth.reset-password');
    })->name('reset-password-form.show');
    Route::get('reset-password/{token?}', function ($token = null) {
        return view('auth.password-reset')->with(['token' => $token]);
    })->name('reset-password.show');
    
    Route::get('ui-test', function ($token = null) {
        return view('ui-elements');
    });
    
    
    Route::get('resend-email-verification',                 [ AuthController::class, 'resendEmailVerification' ])->name('resend-email-verification');
    Route::get('resend-phone-verification',                 [ AuthController::class, 'resendPhoneVerification' ])->name('resend-phone-verification');
    Route::get('reset-password-email',                      [ AuthController::class, 'resetPasswordEmail' ])->name('reset-password-email');
    Route::post('register',                                 [ AuthController::class, 'register' ])->name('register.submit');
    Route::post('login',                                    [ AuthController::class, 'login' ])->name('login.submit');
    Route::post('reset-password/{token?}',                  [ AuthController::class, 'resetPassword' ])->name('reset-password.submit');
    Route::post('phone-verify',                             [ AuthController::class, 'verifyPhone' ])->name('phone-verify.submit');
    Route::get('verify-email',                              [ AuthController::class, 'verifyEmail' ])->name('verify.email');
    Route::get('verify-phone',                              [ AuthController::class, 'verifyPhone' ])->name('verify.phone');
    Route::get('logout',                                    [AuthController::class, 'logout'])->name('auth.logout');
    
    
    Route::group(['middleware' => 'authadmin' ],function(){
        Route::get('dashboard', function() {
            return view('index');
        })->name("logged.dashboard");
    
        Route::get('account/edit', function() {
            return view('profile.edit');
        })->name("profile.edit");
        Route::patch('account/update',                      [AccountController::class, 'updateProfile'])->name("profile.update");
        Route::get('account/active/{account}/{state}',      [AccountController::class, 'setActive'])->name('account.active');

        Route::get('analysis',                              [AnalysisController::class, 'analysis'])->name('analysis.show');
        Route::get('log/export',                            [LogController::class, 'export'])->name('log.export');
        Route::get('log/deleteall',                         [LogController::class, 'deleteall'])->name('log.deleteall');
        Route::get('siteuser/active/{siteuser}/{state}',    [UserController::class, 'setActive'])->name('siteuser.active');

        Route::get('database/backup',                       [DatabaseController::class, 'backup'])->name('database.backup');
        Route::post('database/restore',                     [DatabaseController::class, 'restore'])->name('database.restore');

        Route::get('teacherTransaction/download',           [TeacherTransactionController::class, 'download'])->name('teacherTransaction.download');

        Route::get('freeUser/excelDownload',                [FreeUsersController::class, 'excelDownload'])->name('freeUser.excelDownload');
        Route::post('freeUser/excelUpload',                 [FreeUsersController::class, 'excelUpload'])->name('freeUser.excelUpload');
    
        Route::resources([
            'account'               => AccountController::class, 
            'subject'               => SubjectController::class, 
            'language'              => LanguageController::class, 
            'landingItem'           => LandingItemController::class, 
            'siteuser'              => UserController::class, 
            'transaction'           => TransactionController::class, 
            'course'                => CourseController::class, 
            'lecture'               => LectureController::class, 
            'question'              => QuestionController::class, 
            'log'                   => LogController::class, 
            'setting'               => SettingController::class, 
            'teacherTransaction'    => TeacherTransactionController::class, 
            'freeUser'              => FreeUsersController::class, 
        ]);
    });


});