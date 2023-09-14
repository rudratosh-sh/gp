<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;


class DashboardController extends Controller
{
    // Display the Dashboard
    public function index(Request $request)
    {
        if (auth()->check()) {
            // If authenticated, retrieve the authenticated user's data
            $user = auth()->user();
        }else {
            // If not authenticated, return a 404 error
            abort(Response::HTTP_FORBIDDEN);
        }

        return view('front.dashboard.index', ['user' => $user]);
    }
}
