@extends('layouts.master')
@section('title')
    الفواتير
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    @can('اضافة فاتورة')
                    <a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                            class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>
                    @endcan
                    @can('تصدير EXCEL')
                    <a href="{{ route('excelExport') }}" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                        class="far fa-file-alt"></i>&nbsp; تصدير اكسيل</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table key-buttons text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الفاتوره</th>
                                    <th class="border-bottom-0">تاريخ الإستحقاق</th>
                                    <th class="border-bottom-0">المنتج</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">الخصم</th>
                                    <th class="border-bottom-0">نسبة الضريبة</th>
                                    <th class="border-bottom-0">قيمة الضريبة</th>
                                    <th class="border-bottom-0">الإجمالي</th>
                                    <th class="border-bottom-0">الحالة</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>
                                            <a
                                                href="invoiceDetails/{{ $invoice->id }}">{{ $invoice->section->section_name }}</a>
                                        </td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->rate_vat }}</td>
                                        <td>{{ $invoice->value_vat }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>
                                            @if ($invoice->value_status == 1)
                                                <span class="badge badge-pill badge-success">مدفوعة</span>
                                            @elseif ($invoice->value_status == 2)
                                                <span class="badge badge-pill badge-danger">غير مدفوعة</span>
                                            @else
                                                <span class="badge badge-pill badge-warning">مدفوعة جزئيا</span>
                                            @endif
                                        </td>
                                        <td>{{ $invoice->note }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">العمليات<i class="fas fa-caret-down ml-1"></i>
                                                </button>
                                                <div class="dropdown-menu tx-13">
                                                    @can('تعديل الفاتورة')
                                                    <a class="dropdown-item"
                                                        href=" {{ route('invoices.edit', $invoice->id) }}"><i
                                                            class="typcn typcn-edit"></i>&nbsp;&nbsp;تعديل
                                                        الفاتورة</a>
                                                    @endcan
                                                    @can('حذف الفاتورة')
                                                    <a class="dropdown-item" href="#"
                                                        data-invoice_id="{{ $invoice->id }}" data-toggle="modal"
                                                        data-target="#delete_invoice"><i
                                                            class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                        الفاتورة</a>
                                                    @endcan
                                                    @can('تغير حالة الدفع')
                                                    <a class="dropdown-item"
                                                        href="{{ route('invoices.show', $invoice->id) }}"><i
                                                            class=" text-success fas fa-money-bill"></i>&nbsp;&nbsp;تغير
                                                        حالةالدفع</a>
                                                    @endcan
                                                    @can('ارشفة الفاتورة')
                                                    <a class="dropdown-item" href="#"
                                                        data-invoice_id="{{ $invoice->id }}" data-toggle="modal"
                                                        data-target="#Transfer_invoice"><i
                                                            class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل
                                                        الي
                                                        الارشيف</a>
                                                    @endcan
                                                    @can('طباعةالفاتورة')
                                                    <a class="dropdown-item" href="{{ route('invoice_print',$invoice->id) }}"><i
                                                            class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
                                                        الفاتورة
                                                    </a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/div-->
            </div>
            <!-- row closed -->
            {{-- delete modal --}}
            <div class="modal" id="delete_invoice">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">حذف الفاتورة</h6><button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{ route('invoices.destroy', 'test') }}" method="POST" autocomplete="off">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                <p>هل انت متاكد من عملية الحذف ؟</p>
                                <input type="hidden" name="invoice_id" id="invoice_id" value="">
                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-danger" type="submit">تأكيد</button>
                                <button class="btn ripple btn-secondary" data-dismiss="modal"
                                    type="button">الغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Archieve modal --}}
            <div class="modal" id="Transfer_invoice">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">أرشفة الفاتورة</h6><button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{ route('archieve_invoice') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="modal-body">
                                <p>هل انت متاكد من عمليةالأرشفة ؟</p>
                                <input type="hidden" name="invoice_id" id="invoice_id" value="">
                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-success" type="submit">تأكيد</button>
                                <button class="btn ripple btn-secondary" data-dismiss="modal"
                                    type="button">الغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <script>
        $('#delete_invoice').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var invoice_id = button.data('invoice_id');
            var modal = $(this);
            modal.find('.modal-body #invoice_id').val(invoice_id);
        });

        $('#Transfer_invoice').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var invoice_id = button.data('invoice_id');
            var modal = $(this);
            modal.find('.modal-body #invoice_id').val(invoice_id);
        });
    </script>
@endsection
