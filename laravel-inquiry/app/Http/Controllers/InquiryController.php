<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\User;
use App\Services\InquiryMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\StoreInquiryRequest;

class InquiryController extends Controller
{

    public function __construct(private readonly InquiryMailService $service)
    {
    }

    /**
     * Display an inquiry form.
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
     * @param StoreInquiryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreInquiryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $inquiry = new Inquiry();

        $inquiry->fill($validated)->save();

        /** @var User $user */
        foreach (User::query()->cursor() as $user) {
            $content = $inquiry->content;
            $this->service->send($user, $content);
        }

        return redirect()->route("inquiries.complete");
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


