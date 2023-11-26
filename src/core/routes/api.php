<?php

use App\Http\Controllers\DevController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user/{id}', function (Request $request) {
    return 'User ' . $request->id;
});

Route::post('lobby', function (Request $request): JsonResponse {
    $response = [
        'success' => 1,
    ];

    try {
        DB::table('lobbies')->insert([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'amount' => $request->amount,
            'user_ids' => $request->user_id,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    } catch (\Throwable $e) {
        $response = [
            'errors' => $e->getMessage(),
        ];
    }

    return response()->json($response);
});

Route::any('lobbies', function (Request $request): JsonResponse {
    $response = [];

    $maxIdInit = $maxId = DB::table('lobbies')
        ->select(DB::raw('MAX(id) as max_id'))
        ->whereIn('status', ['1'])
        ->first();

    while ($request->sleep && $maxIdInit == $maxId) {
        if ($request->sleep > 0) {
            sleep($request->sleep);
        }

        $maxId = DB::table('lobbies')->select(DB::raw('MAX(id) as max_id'))
            ->whereIn('status', ['1'])
            ->first();
    }

    $response = DB::table('lobbies')
        ->whereIn('status', ['1'])
        ->get()
        ->toArray();

    return response()->json($response);
});
