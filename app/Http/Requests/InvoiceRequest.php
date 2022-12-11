<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'invoice_number' => 'required|unique:invoices,invoice_number,except,id',
            'product' => 'required',
            'section_id' => 'required',
            'invoice_date' => 'required|date',
            'due_date' => 'required|after_or_equal:invoice_date|date',
            'payment_date' => 'after_or_equal:invoice_date|date',
            'amount_collection' => 'required',
            'amount_commission' => 'required',
            'rate_vat' => 'required',
            'discount' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'invoice_number.required' => 'يرجى ادخال رقم الفاتورة',
            'invoice_number.unique' => 'رقم الفاتورة مسجل مسبقا',
            'product.required' => 'اسم المنتج مطلوب',
            'section_id.required' => 'يرجى اختيار اسم القسم',
            'invoice_date.required' => 'تاريخ الفاتورة مطلوب',
            'invoice_date.date' => 'يرجى ادخال تاريخ صحيح',
            'due_date.required' => 'تاريخ استحقاق الفاتورة مطلوب',
            'due_date.after_or_equal' => 'يجب ادخال تاريخ بعد او يساوي تاريخ تسجيل الفاتورة',
            'amount_collection.required' => 'مبلغ التحصيل مطلوب',
            'amount_commission.required' => 'قيمة العموله مطلوبة',
            'rate_vat.required' => 'يرجى اختيار ضريبة القيمة المضافة',
            'discount.required' => 'قيمة الخصم مطلوبة',
        ];
    }
}
