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
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل
                    فاتورة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @include('session.session')
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        تفاصيل الفاتورة رقم <span class="text-danger">({{ $invoice->invoice_number }})</span>
                    </div>
                    <br>
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات
                                                    الفاتورة</a></li>
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                                            <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab4">
                                            <div class="card-body">
                                                <div class="table-responsive mt-15">
                                                    <table class="table table-bordered mg-b-0 text-md-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th class="border-bottom-0">رقم الفاتورة</th>
                                                                <th class="border-bottom-0">تاريخ الفاتوره</th>
                                                                <th class="border-bottom-0">تاريخ الإستحقاق</th>
                                                                <th class="border-bottom-0">القسم</th>
                                                                <th class="border-bottom-0">المنتج</th>
                                                                <th class="border-bottom-0">مبلغ التحصيل</th>
                                                                <th class="border-bottom-0">مبلغ العموله</th>
                                                                <th class="border-bottom-0">الخصم</th>
                                                                <th class="border-bottom-0">نسبة الضريبة</th>
                                                                <th class="border-bottom-0">قيمة الضريبة</th>
                                                                <th class="border-bottom-0">الإجمالي مع الضريبة</th>
                                                                <th class="border-bottom-0">الحالة الحالية</th>
                                                                <th class="border-bottom-0">ملاحظات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{ $invoice->invoice_number }}</td>
                                                                <td>{{ $invoice->invoice_date }}</td>
                                                                <td>{{ $invoice->due_date }}</td>
                                                                <td>{{ $invoice->section->section_name }}</td>
                                                                <td>{{ $invoice->product }}</td>
                                                                <td>{{ $invoice->amount_collection }}</td>
                                                                <td>{{ $invoice->amount_commission }}</td>
                                                                <td>{{ $invoice->discount }}</td>
                                                                <td>{{ $invoice->rate_vat }}</td>
                                                                <td>{{ $invoice->value_vat }}</td>
                                                                <td>{{ $invoice->total }}</td>
                                                                <td>
                                                                    @if ($invoice->value_status == 1)
                                                                        <span
                                                                            class="badge badge-pill badge-success">{{ $invoice->status }}</span>
                                                                    @elseif ($invoice->value_status == 2)
                                                                        <span
                                                                            class="badge badge-pill badge-danger">{{ $invoice->status }}</span>
                                                                    @else
                                                                        <span
                                                                            class="badge badge-pill badge-warning">{{ $invoice->status }}</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $invoice->note }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab5">
                                            <div class="table-responsive mt-15">
                                                <table class="table center-aligned-table mb-0 table-hover"
                                                    style="text-align:center">
                                                    <thead>
                                                        <tr class="text-dark">
                                                            <th>#</th>
                                                            <th>رقم الفاتورة</th>
                                                            <th>المنتج</th>
                                                            <th>القسم</th>
                                                            <th>حالة الدفع</th>
                                                            <th>تاريخ الدفع </th>
                                                            <th>ملاحظات</th>
                                                            <th>تاريخ الاضافة </th>
                                                            <th>المستخدم</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 0; ?>
                                                        @foreach ($details as $detail)
                                                            <?php $i++; ?>
                                                            <tr>
                                                                <td>{{ $i }}</td>
                                                                <td>{{ $detail->invoice_number }}</td>
                                                                <td>{{ $detail->product }}</td>
                                                                <td>{{ $invoice->section->section_name }}</td>
                                                                @if ($detail->status_value == 1)
                                                                    <td><span
                                                                            class="badge badge-pill badge-success">مدفوعة</span>
                                                                    </td>
                                                                @elseif($detail->status_value == 2)
                                                                    <td><span class="badge badge-pill badge-danger">غير
                                                                            مدفوعة</span>
                                                                    </td>
                                                                @elseif($detail->status_value == 3)
                                                                    <td><span class="badge badge-pill badge-warning">مدفوعة
                                                                            جزئيا</span>
                                                                    </td>
                                                                @endif
                                                                <td>
                                                                    @if ($detail->payment_date == null)
                                                                        <span class="badge badge-pill badge-danger">لم يتم
                                                                            التسديد بعد</span>
                                                                    @else
                                                                        {{ $detail->payment_date }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ $detail->note }}</td>
                                                                <td>{{ $detail->created_at }}</td>
                                                                <td>{{ $detail->user }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>


                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab6">
                                            <div class="card card-statistics">
                                                <div class="card-body">
                                                    <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                    <form action="{{ route('InvoiceAttachments.store') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="custom-file">
                                                            <input id="customFile" type="file" name="file_name"
                                                                class="custom-file-input" required
                                                                accept=".pdf,.jpg, .png, image/jpeg, image/png">
                                                            <input type="hidden" class="form-control" id="invoice_id"
                                                                name="invoice_id" value="{{ $invoice->id }}">
                                                            <input type="hidden" class="form-control" id="invoice_number"
                                                                value="{{ $invoice->invoice_number }}"
                                                                name="invoice_number">
                                                            <label class="custom-file-label" for="customFile">حدد
                                                                المرفق</label>
                                                        </div> <br><br>
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm">تأكيد</button>
                                                    </form>
                                                </div>

                                                <div class="table-responsive mt-15">
                                                    <table class="table center-aligned-table mb-0 table table-hover"
                                                        style="text-align:center">
                                                        <thead>
                                                            <tr class="text-dark">
                                                                <th scope="col">#</th>
                                                                <th scope="col">اسم الملف</th>
                                                                <th scope="col">قام بالاضافة</th>
                                                                <th scope="col">تاريخ الاضافة</th>
                                                                <th scope="col">العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 0; ?>
                                                            @if (@empty($attachments))
                                                                <tr><td><p>لا توجد بيانات لعرضها</p></td></tr>
                                                            @else 
                                                                @foreach ($attachments as $attachment)
                                                                    <?php $i++; ?>
                                                                    <tr>
                                                                        <td>{{ $i }}</td>
                                                                        <td>{{ $attachment->file_name }}</td>
                                                                        <td>{{ $attachment->created_by }}</td>
                                                                        <td>{{ $attachment->created_at }}</td>
                                                                        <td colspan="2">

                                                                            <a class="btn btn-outline-success btn-sm"
                                                                                href="{{ url('View_file') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}"
                                                                                role="button"><i
                                                                                    class="fas fa-eye"></i>&nbsp;
                                                                                عرض</a>

                                                                            <a class="btn btn-outline-info btn-sm"
                                                                                href="{{ route('download', [$invoice->invoice_number, $attachment->file_name]) }}"
                                                                                role="button"><i
                                                                                    class="fas fa-download"></i>&nbsp;
                                                                                تحميل</a>
                                                                            @can('حذف المرفق')
                                                                            <button class="btn btn-outline-danger btn-sm"
                                                                                data-toggle="modal"
                                                                                data-file_name="{{ $attachment->file_name }}"
                                                                                data-invoice_number="{{ $attachment->invoice_number }}"
                                                                                data-file_id="{{ $attachment->id }}"
                                                                                data-target="#delete_file">حذف</button>
                                                                            @endcan
                                                                        </td>

                                                                    </tr>
                                                                @endforeach                                                                    
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- delete --}}
        <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">

                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h5 class="modal-title">حذف مرفق</h5><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('delete_file') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p>
                            <div class="form-group">
                                <label for="">اسم القسم</label>
                                <input type="hidden" class="form-control" id="file_id" name="file_id">
                                <input type="hidden" class="form-control" id="file_name" name="file_name">
                                <input type="hidden" class="form-control" id="invoice_number" name="invoice_number">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-danger" type="submit">تأكيد</button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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

    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

    <script>
        $('#delete_file').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var id = button.data('file_id');
            var file_name = button.data('file_name');
            var invoice_number = button.data('invoice_number');
            var modal = $(this);
            modal.find('.modal-body #file_id').val(id);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
@endsection
