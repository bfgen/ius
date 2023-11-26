<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DevController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        sleep(10);
        return response()->json([
            'error' => [],
            'success' => [],
            'dev controller' => 1,
            'sad' => 'asd',
            'adsad' => [
                'asdsad' => [
                    'rand_' . rand(),
                ],
            ],
        ]);
    }
}
