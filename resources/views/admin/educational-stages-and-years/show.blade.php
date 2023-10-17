<x-admin-app-layout>

    @push('title')
    <title>المراحل التعليمية - {{ $educationalStage->name }}</title>
    @endpush

    @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
    @endpush

    <x-breadcrumb title="المراحل التعليمية" :breadcrumbs='["الصفحة الرئيسية" => "admin.dashboard", "المراحل التعليمية" => "active"]'></x-breadcrumb>

    <div class="row">
        <div class="col-12">
            
            <div class="float-left">
                <x-modal id="createEducationalYearModal" btn="اضافة سنوات اخري" modal="اضافة سنوات اخري">
                    <form id="add-educational-year">
                        {{ csrf_field() }}
                        <input type="hidden" name="educational_stage_id" value="{{ $educationalStage->id }}">
                        <div class="modal-body">
                            <div id="res"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-primary mr-2">انشاء</button>
                        </div>
                    </form>
                </x-modal>

                <x-modal id="aboutEducationalStageModal" btn="معلومات عن المرحلة التعليمية" modal="معلومات عن المرحلة التعليمية">
                    <div class="modal-body">
                        <textarea name="content" id="content">{!! $educationalStage->content == null ? null : $educationalStage->content !!}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">غلق</button>
                        <button type="button" class="btn btn-primary" id="update-educational-stage-content" data-educational-stage-id="{{ $educationalStage->id }}">تحديث</button>
                    </div>
                </x-modal>

                <x-modal id="updateThumbnailModal" btn="الصورة التعريفية" modal="الصورة التعريفية">
                    <form id="update-thumbnail">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <input type="hidden" name="education_stage_id" value="{{ $educationalStage->id }}">
                            @if($educationalStage->thumbnail != null)
                            <p>الصورة الحالية : </p>
                            <img src="{{ asset('uploads/education-stage/'.$educationalStage->slug.'/'.$educationalStage->thumbnail) }}" class="img-fluid" alt="">
                            <hr>
                            @endif
                            <div class="form-group">
                                <label for="educational_stage_thumbnail">الصورة الجديدة</label>
                                <input type="file" class="form-control" name="educational_stage_thumbnail" id="educational_stage_thumbnail" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            @if($educationalStage->thumbnail == null)
                            <button class="btn btn-success btn-sm font-weight-bold">رفع صورة تعريفية</button>
                            @else
                            <button type="submit" class="btn btn-warning btn-sm font-weight-bold ml-2">تحديث الصورة</button>
                            <button type="button" class="btn btn-danger btn-sm font-weight-bold" id="delete-thumbnail" data-educational-stage-id="{{ $educationalStage->id }}">مسح الصورة</button>
                            @endif
                        </div>
                    </form>
                </x-modal>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">السنوات التعليمية</div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th class="text-right"># الترتيب</th>
                                <th class="text-right">اسم السنة</th>
                                <th class="text-right">مسح / تعديل</th>
                                <th class="text-right">نشر / اخفاء</th>
                                <th class="text-right">عدد المقدمين</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $educationalYears = App\Models\EducationalYear::where('educational_stage_id', $educationalStage->id)->orderBy('order', 'asc')->get();
                        @endphp
                        @foreach($educationalYears as $educationalYear)
                            <tr>
                                <td>
                                    {{ $educationalYear->order }}
                                </td>
                                <td>
                                    {{ $educationalYear->name }}
                                </td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-warning font-weight-bold preview-educational-year-for-update" data-educational-year-id="{{$educationalYear->id}}" data-bs-toggle="modal" data-bs-target="#updateEducationalYearInfoModal">
                                        تعديل
                                    </button>
                                    
                                    <div class="modal fade" id="updateEducationalYearInfoModal" tabindex="-1" role="dialog" aria-labelledby="updateEducationalYearInfoModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div id="educational-year-res"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-danger font-weight-bold delete-educational-year" data-educational-year-id="{{$educationalYear->id}}" >مسح</button>
                                </td>
                                <td>
                                    @if($educationalYear->isPublished)
                                    <button class="btn btn-danger publish-or-unpublish" data-is-published="1" data-educational-year-id="{{$educationalYear->id}}">اخفاء المرحلة التعليمة</button>
                                    @else
                                    <button class="btn btn-success publish-or-unpublish" data-is-published="0" data-educational-year-id="{{$educationalYear->id}}">نشر المرحلة التعليمة</button>
                                    @endif
                                </td>
                                <td>0</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.repeater.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
    $(document).ready(function () {
        $.ajax({
            type : "POST",
            url : "{{ route('admin.preview.educational-stages.form') }}",
            data : {
                "_token" : "{{ csrf_token() }}",
            },
            success : function(data){

                $("#res").html(data);
            }
        });

        CKEDITOR.replace( 'content' );
        
        $("#create-educational-stage").on('submit', function(e){
            e.preventDefault();

            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.educational-stages-and-year.create') }}",
                data : new FormData(this),
                contentType : false,
                processData : false,
                cache : false,
                beforeSend : () => {

                    $("#createNewAlbumModal").modal('hide');

                    Swal.fire({
                        icon: 'info',
                        title: 'يتم انشاء البوم جديد .... برجاء الانتظار',
                        showConfirmButton : false,
                    });

                },
                success : (data) => {

                    Swal.fire({
                        icon: 'success',
                        title: 'تم انشاء البوم جديد',
                        html : data,
                    }).then(() => {

                        // location.reload();
                    });
                },
                error: function (xhr) {
                    var err = JSON.parse(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'حدث خطاء ما',
                        html : err.message
                    });
                }
            });
        });
        
        $("#add-educational-year").on('submit', function(e){
            e.preventDefault();

            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.educational-stage.add-educational-year') }}",
                data : new FormData(this),
                contentType : false,
                processData : false,
                cache : false,
                beforeSend : () => {

                    $("#createNewAlbumModal").modal('hide');

                    Swal.fire({
                        icon: 'info',
                        title: 'يتم اضافة سنوات دراسية جديدة .... برجاء الانتظار',
                        showConfirmButton : false,
                    });

                },
                success : (data) => {

                    Swal.fire({
                        icon: 'success',
                        title: 'تم اضافة سنوات دراسية جديدة',
                        html : data,
                    }).then(() => {

                        location.reload();
                    });
                },
                error: function (xhr) {
                    var err = JSON.parse(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'حدث خطاء ما',
                        html : err.message
                    });
                }
            });
        });
        
        $("#update-thumbnail").on('submit', function(e){
            e.preventDefault();

            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.educational-stage.update.thumbnail') }}",
                data : new FormData(this),
                contentType : false,
                processData : false,
                cache : false,
                beforeSend : () => {

                    $("#updateThumbnailModal").modal('hide');

                    Swal.fire({
                        icon: 'info',
                        title: 'يتم تحديث الصورة التعريفية .... برجاء الانتظار',
                        showConfirmButton : false,
                    });

                },
                success : (data) => {

                    Swal.fire({
                        icon: 'success',
                        title: 'تم تحديث الصورة التعريفية',
                        html : data,
                    }).then(() => {

                        location.reload();
                    });
                },
                error: function (xhr) {
                    var err = JSON.parse(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'حدث خطاء ما',
                        html : err.message
                    });
                }
            });
        });

        $("#delete-thumbnail").on('click', function(e){
            e.preventDefault();

            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.educational-stage.delete.thumbnail') }}",
                data : {
                    "_token" : "{{ csrf_token() }}",
                    "educational_stage_id" : $(this).data("educational-stage-id"),
                },
                beforeSend : () => {

                    $("#updateThumbnailModal").modal('hide');

                    Swal.fire({
                        icon: 'info',
                        title: 'يتم تحديث الصورة التعريفية .... برجاء الانتظار',
                        showConfirmButton : false,
                    });

                },
                success : (data) => {

                    Swal.fire({
                        icon: 'success',
                        title: 'تم تحديث الصورة التعريفية',
                        html : data,
                    }).then(() => {

                        location.reload();
                    });
                },
                error: function (xhr) {
                    var err = JSON.parse(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'حدث خطاء ما',
                        html : err.message
                    });
                }
            });
        });

        $(".preview-educational-year-for-update").on('click', function(e){
            e.preventDefault();

            $("#updateEducationalYearInfoModal").modal('hide');


            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.educational-stage.preview-educational-year-for-update') }}",
                data : {
                    "_token" : "{{ csrf_token() }}",
                    "educational_year_id" : $(this).data("educational-year-id"),
                },
                beforeSend : () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'يتم التحميل برجاء الانتظار',
                        allowOutsideClick : false,
                        showConfirmButton : false,
                    });
                },
                success : (data) => {

                    Swal.close();

                    $("#educational-year-res").html(data);
                }
            });
        });

        $(document).on('submit', '#update-education-year', function(e){
            e.preventDefault();

            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.educational-year.update.info') }}",
                data : new FormData(this),
                contentType : false,
                processData : false,
                cache : false,
                beforeSend : () => {

                    $("#updateEducationalYearInfoModal").modal('hide');

                    Swal.fire({
                        icon: 'info',
                        title: 'يتم تحديث بيانات السنة الدراسية .... برجاء الانتظار',
                        showConfirmButton : false,
                    });
                },
                success : (data) => {

                    Swal.fire({
                        icon: 'success',
                        title: 'تم تحديث بيانات السنة الدراسية',
                        html : data,
                    }).then(() => {

                        location.reload();
                    });
                },
                error: function (xhr) {
                    var err = JSON.parse(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'حدث خطاء ما',
                        html : err.message
                    });
                }
            });
        });

        $(".delete-educational-year").on('click', function(e){
            e.preventDefault();

            var educational_year_id = $(this).data('educational-year-id');

            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.educational-year.delete') }}",
                data : {
                    "_token" : "{{ csrf_token() }}",
                    "educational_year_id" : educational_year_id,
                },
                beforeSend : () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'يتم مسح السنة الدراسية .... برجاء الانتظار',
                        showConfirmButton : false,
                    });
                },
                success : (data) => {

                    Swal.fire({
                        icon: 'success',
                        title: 'تم تحديث بيانات السنة الدراسية',
                        html : data,
                    }).then(() => {

                        location.reload();
                    });
                },
                error: function (xhr) {
                    var err = JSON.parse(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'حدث خطاء ما',
                        html : err.message
                    });
                }
            });
        });

        $("#update-educational-stage-content").on('click', function(e){
            e.preventDefault();

            var educational_stage_id = $(this).data('educational-stage-id');
            var content = CKEDITOR.instances["content"].getData();

            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.educational-stage.update.content') }}",
                data : {
                    "_token" : "{{ csrf_token() }}",
                    "educational_stage_id" : educational_stage_id,
                    "content" : content,
                },
                beforeSend : () => {

                    $("#aboutEducationalStageModal").modal('hide');

                    Swal.fire({
                        icon: 'info',
                        title: 'يتم تغيير محتوي .... برجاء الانتظار',
                        showConfirmButton : false,
                    });

                },
                success : (data) => {

                    Swal.fire({
                        icon: 'success',
                        title: 'تم تغيير محتوي',
                        html : data,
                    }).then(() => {

                        // location.reload();
                    });
                },
                error: function (xhr) {
                    var err = JSON.parse(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'حدث خطاء ما',
                        html : err.message
                    });
                }
            });
        });

        $('.publish-or-unpublish').on('click', function(e){
            e.preventDefault();

            var educational_year_id = $(this).data('educational-year-id');
            var isPublished = $(this).data('is-published');

            var before_send_title = isPublished == "0" ? 'يتم نشر المرحلة التعليمية .... برجاء الانتظار' : 'يتم اخفاء المرحلة التعليمية .... برجاء الانتظار';
            var success_title = isPublished == "0" ? 'تم نشر المرحلة التعليمية' : 'تم اخفاء المرحلة التعليمية';

            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.educational-year.publish-or-unpublish') }}",
                data : {
                    "_token" : "{{ csrf_token() }}",
                    "educational_year_id" : educational_year_id,
                    "isPublished" : isPublished,
                },
                beforeSend : () => {

                    $("#aboutEducationalStageModal").modal('hide');

                    Swal.fire({
                        icon: 'info',
                        title: before_send_title,
                        showConfirmButton : false,
                    });
                },
                success : (data) => {

                    Swal.fire({
                        icon: 'success',
                        title: success_title,
                        html : data,
                    }).then(() => {

                        location.reload();
                    });
                },
                error: function (xhr) {
                    var err = JSON.parse(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'حدث خطاء ما',
                        html : err.message
                    });
                }
            });
        });
    });
    </script>
    @endpush
</x-admin-app-layout>