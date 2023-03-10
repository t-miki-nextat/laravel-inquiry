<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Contracts\View\View;

class AdminController extends Controller
{
    /**
     * @return View
     */
    public function showDashboard(): View
    {
        return view('admin.top');
    }

    private const PER_PAGE = 10;

    /**
     * @return View
     */
    public function index(): View
    {
        $inquiries = Inquiry::query()->orderBy('created_at', 'desc')->paginate(self::PER_PAGE, ['*'], 'page', 'null');
        return view('admin.inquiries', ['inquiries' => $inquiries]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $inquiry = Inquiry::query()->findOrFail($id);

        return view('admin.show', ['inquiry' => $inquiry]);
    }
}
