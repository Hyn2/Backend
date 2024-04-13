<?php

use App\Http\Controllers\UnregisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
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

Route::resource('user', UserController::class)->only([
    'index', 'show'
]);
Route::patch('/user', [UserController::class, 'update']);
/** User Logout */
Route::post('/logout', LogoutController::class);
Route::post('/unregister', UnregisterController::class);
// });
/** User Login */
Route::post('/login', LoginController::class);
/** User Register */
Route::post('/register', RegisterController::class);
/** Store user profile image for preview */
Route::post('/preview', [UserController::class, 'storePreviewImage']);
/** Delete user profile image for preview */
Route::delete('/preview', [UserController::class, 'destroyPreviewImage']);

/* 게시글 검색 요청 */
// 게시글 연관 제목+내용 검색
Route::get('/posts/search/{titleArticle}',[PostController::class, 'search']);
// 게시글 제목+내용 일치 검색
Route::get('/posts/search/{titleArticle}/correct',[PostController::class, 'searchCorrect']);
// 게시글 연관 태그 검색
Route::get('/posts/search/tag/{tag}',[PostController::class, 'relatedPostTags']);

/* 게시물 조회 요청 */
// 특정 id로 조회 요청
Route::get('/posts/{id}', [PostController::class, 'retrievePostId']);
// 특정 태그 게시물 조회
Route::get('/postTags', [PostController::class, 'retrievePostTagId']);
// 조회수 순 조회
Route::get('/postSortingView', [PostController::class, 'retrievePostView']);
// 최근 게시물 순 조회
Route::get('/postSortingRecent', [PostController::class, 'retrieveRecentPost']);

Route::middleware('auth:sanctum')->group(function() {
    /* 게시글 작성 post 요청 받을 시 */
    Route::post('/createPost', [PostController::class, 'createPost']);
    /* 게시글 삭제 요청*/
    Route::delete('/posts/{id}', [PostController::class, 'deletePost']);
    /* 게시물 수정 요청 */
    Route::patch('/posts/update/{id}', [PostController::class, 'updatePost']);
    // 유저 게시글 가져오기
    Route::get('/posts/users/{userId}',[PostController::class, 'userPosts']);
    // 게시글 이미지 AWS(S3) 저장 및 path 반환
    Route::post('/posts/storeImage',[PostController::class,'createImage']);

    // 댓글 게시
    Route::post('/comment/createComment',[CommentController::class, 'createComment']);
    // 댓글 수정
    Route::patch('/comment/update',[CommentController::class, 'updateComment']);
    // 댓글 삭제
    Route::delete('/comment/delete',[CommentController::class, 'deleteComment']);

    // 좋아요 추가
    Route::post('/comment/like',[CommentController::class, 'like']);
    // 좋아요 취소
    Route::delete('/comment/unlike',[CommentController::class, 'unlike']);
});

