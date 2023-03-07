<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Inquiries;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class InquiriesController extends Controller
{
    /**
     * Display a inquiry form.
     *
     * @return View
     */
    public function form(): View
    {
        return view('inquiries.form');
    }

    /**
     * Display a confirm page.
     *
     * @return View
     */
    public function complete(): View
    {
        return view('inquiries.complete');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
     */
    public function store(Request $request): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        $inquiry=new Inquiries;

        $inquiry->name=$request->input('name');
        $inquiry->email=$request->input('email');
        $inquiry->content=$request->input('content');
        $inquiry->type=$request->input('type');
        $inquiry->save();

        return redirect('inquiries/complete');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inquiries $inquiries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inquiries $inquiries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inquiries $inquiries)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inquiries $inquiries)
    {
        //
    }
}
