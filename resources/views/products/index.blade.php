@extends('layouts.master')
@section('title')
    اعدادات المنتجات
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الإعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    المنتجات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row row-sm">
		@include('session.session')
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb8">
                    <div class="d-flex justify-content-between">
                        @can('اضافة منتج')
                        <a class="modal-effect btn btn-md btn-primary" data-effect="effect-scale"
                            data-toggle="modal" href="#modaldemo">اضافة منتج</a>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1" data-page-length="50">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">اسم المنتج</th>
                                    <th class="wd-15p border-bottom-0">اسم القسم</th>
                                    <th class="wd-20p border-bottom-0">الوصف</th>
                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
								@foreach ($products as $product)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $product->product_name }}</td>
										<td>{{ $product->section->section_name }}</td>
										<td>{{ $product->description }}</td>
										<td>
                                            @can('تعديل منتج')
											<a href="#modaldemo2" class="modal-effect btn btn-md btn-info" data-effect="effect-scale"
                                            data-id="{{ $product->id }}" data-product_name="{{ $product->product_name }}" data-section_id="{{ $product->section->id }}" data-section_name="{{ $product->section->section_name }}" data-description="{{ $product->description }}"  title="تعديل" data-toggle="modal"><li class="las la-pen"></li></a>
                                            @endcan
                                            @can('حذف منتج')
											<a class="modal-effect btn btn-md btn-danger" data-effect="effect-scale"
                                            data-id="{{ $product->id }}" data-product_name="{{ $product->product_name }}" title="حذف" data-toggle="modal" href="#modaldemo3"><li class="las la-trash"></li></a>
                                            @endcan
										</td>
									</tr>
                                    @php
                                        $i = $i +1;
                                    @endphp
								@endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
{{-- create modal --}}
        <div class="modal" id="modaldemo">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">اضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('products.store') }}" method="POST">
						@csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">اسم المنتج</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" >
                            </div>
                            <div class="form-group">
                                <label for="">اسم القسم</label>
                                <select class="form-control" name="section_id" id="section_id">
                                    <option value="">اختر القسم</option>
                                    @foreach ($sections as $section)
                                        <option  value="{{ $section->id }}">{{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">الوصف</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit">اضافة</button>
                            <button class="btn ripple btn-danger" data-dismiss="modal" type="button">خروج</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- start edit --}}
        <div class="modal" id="modaldemo2">
            <div class="modal-dialog" role="document">
                
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">تعديل منتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="products/update" method="POST" autocomplete="off">
                        @method('PATCH')
						@csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="section_id" id="section_id">
                            <div class="form-group">
                                <label for="">اسم المنتج</label>
                                <input type="text" class="form-control"  id="product_name" name="product_name" required>
                            </div>
                            <div class="form-group">
                                <label class="my-1 mr-2" for="">اسم القسم</label>
                                <select class="form-control" name="section_name" id="section_name" class="custom-select my-1 mr-sm-2">
                                    @foreach ($sections as $section)
                                        <option >{{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">الوصف</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit">حفظ التعديلات</button>
                            <button class="btn ripple btn-danger" data-dismiss="modal" type="button">خروج</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- end edit --}}
        {{-- start delete --}}
        <div class="modal" id="modaldemo3">
            <div class="modal-dialog" role="document">
                
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف منتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="products/destroy" method="POST" autocomplete="off">
                        @method('DELETE')
						@csrf
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p>
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="">اسم المنتج</label>
                                <input type="text" class="form-control"  id="product_name" name="product_name" readonly required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                            <button class="btn ripple btn-danger" type="submit">تأكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- end delete --}}
    </div>
    <!-- row closed -->
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
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

    <script>
        $('#modaldemo2').on('show.bs.modal',function(e){
            var button = $(e.relatedTarget);
            var id = button.data('id');
            var product_name = button.data('product_name');
            var section_name = button.data('section_name');
            var section_id = button.data('section_id');
            var description = button.data('description');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #product_name').val(product_name);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #section_id').val(section_id);
            modal.find('.modal-body #description').val(description);
        });

        $('#modaldemo3').on('show.bs.modal',function(e){
            var button = $(e.relatedTarget);
            var id = button.data('id');
            var product_name = button.data('product_name');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #product_name').val(product_name);
        });
    </script>
@endsection
