<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\MessageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Apartment;


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
Route::get('/', [HomeController::class, 'index'])->name('home');

// Middleware controlla se l'utente è autenticato e verificato; se sì, allora le rotte vengono eseguite;
// se no entra in gioco la rotta di fallback che rimanda alla dashboard: ma se non è autenticato,
// allora viene rimandato alla login (e questo è definito in app/Http/Middleware/Authenticate.php)
Route::middleware(['auth', 'verified'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('apartments', ApartmentController::class)->parameters(['apartments'=>'apartment:slug']);
    Route::post('apartments/{apartment}/promote', [ApartmentController::class, 'promote'])->name('apartments.promote');
    Route::resource('services', ServiceController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('messages', MessageController::class);
});

// // Rotta per visualizzare le promozioni nella vista degli appartamenti
// Route::get('/promotions', function () {
//     // Recupera le promozioni dal database
//     $promotions = DB::table('promotions')->get();
//     $apartments = App\Models\Apartment::paginate(10);
//     return view('admin.apartments.index', compact('promotions', 'apartments'));
// });

// // Rotta per scegliere una promozione per un appartamento
// Route::post('/promotions/choose', function (Request $request) {
//     // Valida la richiesta
//     $request->validate([
//         'promotion_id' => 'required|exists:promotions,id',
//     ]);

//     // Logica per salvare la promozione scelta, ad esempio per un appartamento
//     // Esegui le operazioni necessarie per salvare la scelta dell'utente
//     // $apartment->update(['promotion_id' => $request->promotion_id]);

//     return redirect()->back()->with('message', 'Promozione scelta con successo!');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::fallback(function () {
    return redirect()->route('admin.dashboard');
});
