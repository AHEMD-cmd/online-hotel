<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\FaqController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\RoomController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\PhotoController;
use App\Http\Controllers\Front\TermsController;
use App\Http\Controllers\Front\VideoController;
use App\Http\Controllers\Front\BookingController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\PrivacyController;
use App\Http\Controllers\Front\SubscriberController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';


/* Front */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/photo-gallery', [PhotoController::class, 'index'])->name('photo.gallery');
Route::get('/video-gallery', [VideoController::class, 'index'])->name('video.gallery');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/terms-and-conditions', [TermsController::class, 'index'])->name('terms');
Route::get('/privacy-policy', [PrivacyController::class, 'index'])->name('privacy');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send-email', [ContactController::class, 'sendEmail'])->name('contact.send.email');
Route::post('/subscriber/send-email', [SubscriberController::class, 'sendEmail'])->name('subscriber.send.email');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::post('/cart', [BookingController::class, 'store'])->name('cart.store');
Route::get('/cart', [BookingController::class, 'index'])->name('cart');
Route::get('/cart/delete/{id}', [BookingController::class, 'delete'])->name('cart.delete');
Route::get('/checkout', [BookingController::class, 'checkout'])->name('checkout')->middleware('auth');
Route::post('/payment', [BookingController::class, 'payment'])->name('payment')->middleware('auth');


Route::post('/payment/pay', [PaymentController::class, 'payment'])->name('payment.pay');


Route::get('/paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
Route::get('/paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');

Route::get('/stripe/success', [PaymentController::class, 'stripeSuccess'])->name('stripe.success');
Route::get('/stripe/cancel', [PaymentController::class, 'stripeCancel'])->name('stripe.cancel');