<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\SubjectApiController;
use App\Http\Controllers\api\CourseApiController;
use App\Http\Controllers\api\LectureApiController;
use App\Http\Controllers\api\LanguageApiController;
use App\Http\Controllers\api\CouponController;
use App\Http\Controllers\api\CardApiController;
use App\Http\Controllers\api\TransactionApiController;
use App\Http\Controllers\api\QuestionLogApiController;
use App\Http\Controllers\api\VideoLogApiController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [UserController::class, 'store']);
Route::post('/sendOTP', [UserController::class, 'sendOTP']);
Route::post('/checkOTP', [UserController::class, 'checkOTP']);
Route::get('/translations/{locale}', [LanguageApiController::class, 'translations']);
Route::get('/settings', [UserController::class, 'settings']);

Route::group(['middleware' => 'jwt.verify'], function () {

    Route::get('transactionApi/getToken',       [TransactionApiController::class, "getToken"]);
    Route::get('transactionApi/config',         [TransactionApiController::class, 'getGooglePayConfig']);
    Route::post('transactionApi/createOrder',   [TransactionApiController::class, "createOrder"]);
    Route::post('transactionApi/captureOrder',  [TransactionApiController::class, "captureOrder"]);
    Route::get('lectureApi/checkQs',            [LectureApiController::class, "checkQs"]);


    Route::resource('user',                 UserController::class);
    Route::resource('subjectApi',           SubjectApiController::class);
    Route::resource('courseApi',            CourseApiController::class);
    Route::resource('lectureApi',           LectureApiController::class);
    Route::resource('couponApi',            CouponController::class);
    Route::resource('cardApi',              CardApiController::class);
    Route::resource('transactionApi',       TransactionApiController::class);
    Route::resource('questionLogApi',       QuestionLogApiController::class);
    Route::resource('videoLogApi',          VideoLogApiController::class);
});