<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/8/17
 * Time: 5:48 PM
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $userId = Auth::id();

        return view('dashboard.dashboard', [
            'userId' => $userId
        ]);
    }
}