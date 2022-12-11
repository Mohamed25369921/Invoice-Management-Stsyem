<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice_attachment;
use Illuminate\Support\Facades\Auth;

class InvoiceAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'hi';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'file_name' => 'mimes:png,jpg,pdf,jpeg'
        ],[
            'file_name.mimes' => 'لابد ان تكون صيغة الملف pdf,jpg,jpeg,png'
        ]);
        $file = $request->file('file_name');
        $file_name = $file->getClientOriginalName();
        Invoice_attachment::create([
            'invoice_id' => $request->invoice_id,
            'invoice_number' => $request->invoice_number,
            'file_name' => $file_name,
            'created_by' => Auth::user()->name,
        ]);
        $file->move(public_path('Attachments/' . $request->invoice_number), $file_name);
        return redirect()->back()->with(['success' => 'تم اضافة المرفق بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice_attachment $invoice_attachment)
    {
        //
    }
}
