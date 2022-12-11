<?php

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (isset(auth()->user()->name)) {
        return redirect()->route('home');
    } else {
        return view('auth.login');
    }
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('invoices', InvoiceController::class);


    Route::get('test', function () {
        $user = User::find(1);
        return $user->role[0]->name;
    });


    Route::post('status_update/{id}', [InvoiceController::class, 'status_update'])->name('status_update');
    Route::resource('sections', SectionController::class);
    Route::resource('products', ProductController::class);
    Route::resource('InvoiceAttachments', InvoiceAttachmentController::class);
    Route::post('delete_file', [InvoiceDetailsController::class, 'destroy'])->name('delete_file');
    Route::get('section/{id}', [InvoiceController::class, 'get_products']);
    Route::get('paid-invoices', [InvoiceController::class, 'paid_invoices']);
    Route::get('unpaid-invoices', [InvoiceController::class, 'unpaid_invoices']);
    Route::get('partial-invoices', [InvoiceController::class, 'partial_invoices']);
    Route::get('show-archieved-invoices', [InvoiceController::class, 'show_archieved_invoices'])->name('show-archieved-invoices');
    Route::post('destroy_archieved_invoice', [InvoiceController::class, 'destroy_archieved_invoice'])->name('destroy_archieved_invoice');
    Route::post('archieve_invoice', [InvoiceController::class, 'archieve_invoice'])->name('archieve_invoice');
    Route::get('excelExport', [InvoiceController::class, 'excelExport'])->name('excelExport');
    Route::post('unarchieve_invoice', [InvoiceController::class, 'unarchieve_invoice'])->name('unarchieve_invoice');
    Route::get('invoice_print/{id}', [InvoiceController::class, 'invoice_print'])->name('invoice_print');
    Route::get('invoiceDetails/{id}', [InvoiceDetailsController::class, 'edit'])->name('invoiceDetails');
    Route::get('View_file/{invoice_number}/{file_name}', [InvoiceDetailsController::class, 'open_file']);
    Route::get('download/{invoice_number}/{file_name}', [InvoiceDetailsController::class, 'download_file'])->name('download');

    Route::get('invoices_index', [ReportController::class,'invoices_index'])->name('invoices_index');

    Route::post('search_invoices', [ReportController::class,'search_invoices']);

    Route::get('customers_index', [ReportController::class,'customers_index'])->name("customers_index");

    Route::post('search_customers', [ReportController::class,'search_customers'])->name('search_customers');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::get('/markAsRead',[InvoiceController::class,'markAsRead'])->name('mark');



    Route::get('/{page}', [AdminController::class, 'index']);
});
