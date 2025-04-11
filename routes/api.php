 <?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Token-based Sanctum routes (NO CSRF)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
