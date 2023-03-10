<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * @return View
     */
    public function showDashboard(): View
    {
        return view('admin.top');
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $inquiries = Inquiry::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.inquiries', ['inquiries'=>$inquiries]);
    }
}
