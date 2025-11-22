<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $userCount = User::count();
        $sessionCount = Schema::hasTable('sessions') ? DB::table('sessions')->count() : 0;
        $jobCount = Schema::hasTable('jobs') ? DB::table('jobs')->count() : 0;

        $recentUsers = User::orderByDesc('created_at')->limit(5)->get();

        return view('admin.dashboard', compact('userCount', 'sessionCount', 'jobCount', 'recentUsers'));
    }
}
