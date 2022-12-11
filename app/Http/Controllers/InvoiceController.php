<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Exports\InvoicesExport;
use App\Models\Invoice_details;
use App\Models\Invoice_attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\InvoiceRequest;
use App\Notifications\InvoiceNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class InvoiceController extends Controller
{
    
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.index',compact('invoices'));
    }

    
    public function create()
    {
        $sections = Section::all();
        return view('invoices.add_invoice',compact('sections'));
    }

    public function store(InvoiceRequest $request)
    {
        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'section_id' => $request->section_id,
            'product' => $request->product,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = Invoice::latest()->first()->id;
        Invoice_details::create([
            'invoice_number' => $request->invoice_number,
            'invoice_id' => $invoice_id,
            'product' => $request->product,
            'section' => $request->section_id,
            'status' => 'غير مدفوعة',
            'status_value' => 2,
            'note' => $request->note,
            'user' => Auth::user()->name,
        ]);

        if($request->hasFile('file')){
            $file = $request->file;
            $file_name = $file->getClientOriginalName();
            Invoice_attachment::create([
                'invoice_id' => $invoice_id,
                'invoice_number' => $request->invoice_number,
                'file_name' => $file_name,
                'created_by' => Auth::user()->name,
            ]);
            $file->move(public_path('Attachments\\' . $request->invoice_number ) , $file_name);
        }

        $user = User::get();
        $invoice = Invoice::latest()->first();
        Notification::send($user,new InvoiceNotification($invoice));
        return redirect()->route('invoices.index')->with(['success' => 'تم اضافة الفاتورة بنجاح']);
    }

    
    public function show($id)
    {
        $invoice = Invoice::find($id);
        return view('invoices.status_update',compact('invoice'));
    }

    
    public function edit($id)
    {
        $invoice = Invoice::find($id);
        $sections = Section::all();
        return view('invoices.edit_invoice',compact('invoice','sections'));
    }

    
    public function update(InvoiceRequest $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $fileOld = public_path('Attachments\\' . $invoice->invoice_number);
        $fileNew = public_path('Attachments\\' . $request->invoice_number);
        rename($fileOld,$fileNew);
        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'section_id' => $request->section_id,
            'product' => $request->product,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
        ]);
        Invoice_details::where('invoice_id',$id)->first()->update([
            'invoice_number' => $request->invoice_number,
        ]);
        Invoice_attachment::where('invoice_id',$id)->first()->update([
            'invoice_number' => $request->invoice_number,
        ]);
        return redirect()->route('invoices.index')->with(['success' => 'تم تعديل الفاتورة بنجاح']);
    }

    
    public function destroy(Request $request)
    {
        $invoice = Invoice::findOrFail($request->invoice_id);
        $attachment = Invoice_attachment::where('invoice_id',$request->invoice_id)->first();
        if (isset($attachment)) {
            $file = public_path('Attachments\\' . $attachment->invoice_number);
            array_map('unlink', glob("$file/*.*"));
            rmdir($file);
        }
        $invoice->forceDelete();
        return redirect()->route('invoices.index')->with(['success' => 'تم حذف الفاتورة بنجاح']);
    }

    public function get_products($id)
    {
        $products = DB::table('products')->where('section_id',$id)->pluck('id','product_name');
        return json_encode($products);
    }

    public function status_update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            
            'value_status' => 'required',
            'payment_date' => 'required|after_or_equal:invoice_date|date',
        ],[
            'payment_date.required' => 'تاريخ دفع الفاتورة مطلوب',
            'payment_date.date' => 'يرجى ادخال تاريخ صحيح',
            'payment_date.after_or_equal' => 'يجب ادخال تاريخ بعد او يساوي تاريخ تسجيل الفاتورة',
            'value_status.required' => 'يرجى اختيار حالة دفع الفاتورة',
        ])->validate();

        if($request->value_status == 1){
            $status = 'مدفوعة';
        }elseif($request->value_status == 2){
            $status = 'غير مدفوعة';
        }else{
            $status = 'مدفوعة جزئيا';
        }

        $invoice = Invoice::find($id);

        $invoice->update([
            'value_status' => $request->value_status,
            'payment_date' => $request->payment_date,
            'status' => $status,
        ]);

        Invoice_details::create([
            'invoice_number' => $request->invoice_number,
            'invoice_id' => $id,
            'product' => $request->product,
            'section' => $request->section_id,
            'status' => $status,
            'payment_date' => $request->payment_date,
            'status_value' => $request->value_status,
            'note' => $request->note,
            'user' => Auth::user()->name,
        ]);

        return redirect()->route('invoices.index')->with(['success' => 'تم تغيير حالة الفاتورة بنجاح']);
    }

    public function paid_invoices(){
        $invoices = Invoice::where('value_status',1)->get();
        return view('invoices.paid_invoices',compact('invoices'));
    }

    public function unpaid_invoices(){
        $invoices = Invoice::where('value_status',2)->get();
        return view('invoices.unpaid_invoices',compact('invoices'));
    }

    public function partial_invoices(){
        $invoices = Invoice::where('value_status',3)->get();
        return view('invoices.partial_invoices',compact('invoices'));
    }

    public function show_archieved_invoices(){
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archieved_invoices',compact('invoices'));
    }
    
    public function archieve_invoice(Request $request){
        $invoice = Invoice::findOrFail($request->invoice_id);
        $invoice->delete();
        return redirect()->route('invoices.index')->with(['success' => 'تم أرشفة الفاتورة بنجاح']);
    }

    public function unarchieve_invoice(Request $request){
        $invoice = Invoice::withTrashed()->where('id',$request->invoice_id)->first();
        $invoice->restore();
        return redirect()->route('show-archieved-invoices')->with(['success' => 'تم الغاء أرشفة الفاتورة بنجاح']);
    }

    public function destroy_archieved_invoice(Request $request){
        $invoice = Invoice::withTrashed()->where('id',$request->invoice_id)->first();
        $attachment = Invoice_attachment::where('invoice_id',$request->invoice_id)->first();
        if (isset($attachment)) {
            $file = public_path('Attachments\\' . $attachment->invoice_number);
            array_map('unlink', glob("$file/*.*"));
            rmdir($file);
        }
        $invoice->forceDelete();
        return redirect()->route('show-archieved-invoices')->with(['success' => 'تم حذف الفاتورة نهائيا بنجاح']);
    }

    public function invoice_print($id){
        $invoice = Invoice::find($id);
        return view('invoices.print',compact('invoice'));
    }

    public function excelExport() 
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }
    
    public function markAsRead() 
    {
        auth()->user()->unreadNotifications->markAsRead();
    
        return redirect()->back();
    }
    
}
