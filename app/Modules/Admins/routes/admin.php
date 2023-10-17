<?php

use App\Modules\Admins\Http\Controllers\AdmissionController;
use App\Modules\Admins\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Modules\Admins\Http\Controllers\BoardMemberController;
use App\Modules\Admins\Http\Controllers\EducationalStagesAndYearsController;
use App\Modules\Admins\Http\Controllers\GalleryController;
use App\Modules\Admins\Http\Controllers\GuardianAndStudents\GuardianController;
use App\Modules\Admins\Http\Controllers\GuardianAndStudents\StudentController;
use App\Modules\Admins\Http\Controllers\PolicyController;
use App\Modules\Admins\Http\Controllers\TermsAndConditionController;

Route::middleware(['web', 'admin.auth', 'admin.verified'])->get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::group(['as' => 'admin.', 'prefix' => '/admin', 'middleware' => ['web', 'admin.auth']], function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/switch-mode', [ProfileController::class, 'switchMode'])->name('profile.switch-mode');

    // Admissions Routes
    Route::get('/admissions', [AdmissionController::class, 'index'])->name('admissions');
    Route::get('/admission/{slug}', [AdmissionController::class, 'show'])->name('admission.show');

    // Guardian Routes
    Route::get('/guardians', [GuardianController::class, 'index'])->name('guardians');
    
    // Students Routes
    Route::get('/students', [StudentController::class, 'index'])->name('students');

    // inqueries routes
    Route::get('/inqueries', [App\Modules\Admins\Http\Controllers\InqueryController::class, 'inqueries'])->name('inqueries');
    Route::get('/inqueries/read', [App\Modules\Admins\Http\Controllers\InqueryController::class, 'read'])->name('inqueries.read');
    Route::post('/ajax/open-inquery-msg', [App\Modules\Admins\Http\Controllers\InqueryController::class, 'openInqueryMsg'])->name('ajax.open-inquery-msg');
    Route::post('/ajax/mark-msg-as-read', [App\Modules\Admins\Http\Controllers\InqueryController::class, 'markMessageAsRead'])->name('ajax.mark-msg-as-read');

    // terms and conditions routes
    Route::get('/terms-and-conditions', [TermsAndConditionController::class, 'termsAndConditions'])->name('terms-and-conditions');
    Route::post('/terms-and-conditions/update', [TermsAndConditionController::class, 'update'])->name('terms-and-conditions.update');

    // policy routes
    Route::get('/policy', [PolicyController::class, 'policy'])->name('policy');
    Route::post('/policy/update', [PolicyController::class, 'update'])->name('policy.update');

    // gallery routes
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
    Route::get('/gallery/{slug}/show', [GalleryController::class, 'show'])->name('gallery.show');
    Route::post('/ajax/gallery/album/create', [GalleryController::class, 'createNewAlbum'])->name('ajax.admin.gallery.album.create');
    Route::post('/ajax/gallery/album/delete', [GalleryController::class, 'deleteAlbum'])->name('ajax.admin.gallery.album.delete');
    Route::post('/ajax/gallery/album/update/title', [GalleryController::class, 'updateAlbumTitle'])->name('ajax.admin.gallery.album.update.title');
    Route::post('/ajax/gallery/album/update/thumbnail', [GalleryController::class, 'updateAlbumThumbnail'])->name('ajax.admin.gallery.album.update.thumbnail');
    Route::post('/ajax/gallery/album/delete/thumbnail', [GalleryController::class, 'deleteAlbumThumbnail'])->name('ajax.admin.gallery.album.delete.thumbnail');
    Route::post('/ajax/gallery/album/publish', [GalleryController::class, 'publishAlbum'])->name('ajax.admin.gallery.album.publish');
    Route::post('/ajax/gallery/album/unpublish', [GalleryController::class, 'unpublishAlbum'])->name('ajax.admin.gallery.album.unpublish');
    Route::post('/ajax/gallery/album/delete-all-photos', [GalleryController::class, 'deleteAllPhotosInAlbum'])->name('ajax.admin.gallery.album.delete-all-photos');
    Route::post('/ajax/gallery/album/delete-photo', [GalleryController::class, 'deletePhoto'])->name('ajax.admin.gallery.album.delete-photo');
    Route::post('/ajax/gallery/photos/upload', [GalleryController::class, 'uploadPhotos'])->name('ajax.admin.gallery.photos.upload');

    // board member routes
    Route::get('/board-members', [BoardMemberController::class, 'index'])->name('board-members');
    Route::get('/board-member/show/{slug}', [BoardMemberController::class, 'show'])->name('board-member.show');
    Route::post('/ajax/board-member/create', [BoardMemberController::class, 'addMewBoardMember'])->name('ajax.board-member.create');
    Route::post('/ajax/board-member/update/info', [BoardMemberController::class, 'updateInfo'])->name('ajax.board-member.update.info');
    Route::post('/ajax/board-member/update/image', [BoardMemberController::class, 'updateImage'])->name('ajax.board-member.update.image');
    Route::post('/ajax/board-member/delete', [BoardMemberController::class, 'delete'])->name('ajax.board-member.delete');
    Route::post('/ajax/board-member/delete/image', [BoardMemberController::class, 'deleteImage'])->name('ajax.board-member.delete.image');
    Route::post('/ajax/board-member/suspend', [BoardMemberController::class, 'suspend'])->name('ajax.board-member.suspend');
    Route::post('/ajax/board-member/publish', [BoardMemberController::class, 'publish'])->name('ajax.board-member.publish');

    // educational stages and years routes
    Route::get('/educational-stages-and-years', [EducationalStagesAndYearsController::class, 'index'])->name('educational-stages-and-years');
    Route::get('/educational-stage/show/{slug}', [EducationalStagesAndYearsController::class, 'show'])->name('educational-stage.show');
    Route::post('/ajax/educational-stages-and-year/create', [EducationalStagesAndYearsController::class, 'create'])->name('ajax.educational-stages-and-year.create');
    Route::post('/preview/educational-stages/form', [EducationalStagesAndYearsController::class, 'educationStageForm'])->name('preview.educational-stages.form');
    Route::post('/ajax/educational-stage/add-educational-year', [EducationalStagesAndYearsController::class, 'addEducationalYear'])->name('ajax.educational-stage.add-educational-year');
    Route::post('/ajax/educational-stage/update/content', [EducationalStagesAndYearsController::class, 'updateEducationalStageContent'])->name('ajax.educational-stage.update.content');
    Route::post('/ajax/educational-stage/update/thumbnail', [EducationalStagesAndYearsController::class, 'updateEducationalStageThumbnail'])->name('ajax.educational-stage.update.thumbnail');
    Route::post('/ajax/educational-stage/delete/thumbnail', [EducationalStagesAndYearsController::class, 'deleteEducationalStageThumbnail'])->name('ajax.educational-stage.delete.thumbnail');
    Route::post('/ajax/educational-stage/preview-educational-year-for-update', [EducationalStagesAndYearsController::class, 'previewEducationalYearForUpdate'])->name('ajax.educational-stage.preview-educational-year-for-update');
    Route::post('/ajax/educational-year/update/info', [EducationalStagesAndYearsController::class, 'updateEducationalYearInfo'])->name('ajax.educational-year.update.info');
    Route::post('/ajax/educational-year/delete', [EducationalStagesAndYearsController::class, 'deleteEducationalYearInfo'])->name('ajax.educational-year.delete');
    Route::post('/ajax/educational-year/publish-or-unpublish', [EducationalStagesAndYearsController::class, 'publishOrUnpublish'])->name('ajax.educational-year.publish-or-unpublish');
});

require __DIR__.'/auth.php';
