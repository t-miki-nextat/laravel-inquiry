<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class InquiryController extends Controller
{
    /**
     * Display an inquiry form.
     *
     * @return View
     */
    public function form(): View
    {
        return view('inquiry.form');
    }

    /**
     * Display a confirm page.
     *
     * @return View
     */
    public function complete(): View
    {
        return view('inquiry.complete');
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
        $inquiry=new Inquiry;

        $inquiry->name=$request->input('name');
        $inquiry->email=$request->input('email');
        $inquiry->content=$request->input('content');
        $inquiry->type=$request->input('type');
        $inquiry->save();

        return redirect('complete');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inquiry $inquiries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inquiry $inquiries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inquiry $inquiries)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inquiry $inquiries)
    {
        //
    }
}
