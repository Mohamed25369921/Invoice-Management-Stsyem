<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Report;
use App\Models\Section;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Trig\Secant;

class ReportController extends Controller
{

    public function invoices_index()
    {
        return view('reports.invoices_reports');
    }


    public function customers_index()
    {
        $sections = Section::all();
        return view('reports.customers_reports', compact('sections'));
    }

    public function search_invoices(Request $request)
    {
        if ($request->radio == 1) {
            if ($request->type == '' && $request->start_at == '' && $request->end_at == '') {
                $details = Invoice::all();
                return view('reports.invoices_reports', compact('details'));
            } elseif ($request->type && $request->start_at == '' && $request->end_at == '') {
                $details = Invoice::where('value_status', $request->type)->get();
                $type = $request->type;
                return view('reports.invoices_reports', compact('details', 'type'));
            } else {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;
                $details = Invoice::whereBetween('invoice_date', [$start_at, $end_at])->where('value_status', $request->type)->get();
                return view('reports.invoices_reports', compact('start_at', 'end_at', 'details', 'type'));
            }
        } else {
            $details = Invoice::where('invoice_number', $request->invoice_number)->get();
            $invoice_number = $request->invoice_number;
            return view('reports.invoices_reports', compact('details', 'invoice_number'));
        }
    }

    public function search_customers(Request $request)
    {
        $sections = Section::all();
        $new_section = $request->section;

        if ($request->section == '' && $request->product == '' && $request->start_at == '' && $request->end_at == '') {
            $details = Invoice::all();
            return view('reports.customers_reports', compact('details', 'sections'));
        } elseif ($request->section && $request->product && $request->start_at == '' && $request->end_at == '') {
            $details = Invoice::where('section_id', $request->section)->where('product', $request->product)->get();
            return view('reports.customers_reports', compact('details', 'sections', 'new_section'));
        } else {
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $details = Invoice::whereBetween('invoice_date', [$start_at, $end_at])->where(['section_id' => $request->section, 'product' => $request->product])->get();
            return view('reports.customers_reports', compact('details', 'sections', 'start_at', 'end_at', 'new_section'));
        }
    }
}
