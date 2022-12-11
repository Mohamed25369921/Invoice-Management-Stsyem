<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Invoice_details;
use function PHPSTORM_META\type;
use App\Models\Invoice_attachment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailsController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Invoice_details $invoice_details)
    {
        //
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $details = Invoice_details::where('invoice_id', $id)->get();
        $attachments = Invoice_attachment::where('invoice_id', $id)->get();
        return view('invoices.invoice_details', compact('invoice', 'details', 'attachments'));
    }

    public function update(Request $request, Invoice_details $invoice_details)
    {
        //
    }

    public function destroy(Request $request)
    {
        try {
            Invoice_attachment::destroy($request->file_id);
            unlink(public_path() . '\\Attachments\\' . $request->invoice_number . '\\' . $request->file_name);
            return redirect()->back()->with(['success' => 'تم حذف المرفق بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'حدث خطأ ما' . $ex]);
        }
    }

    public function open_file($invoice_number, $file_name)
    {
        $file = public_path('Attachments/' . $invoice_number . '/' . $file_name);
        return response()->file($file);
    }

    public function download_file($invoice_number, $file_name)
    {
        $file = public_path('Attachments/' . $invoice_number . '/' . $file_name);
        return response()->download($file);
    }

}
