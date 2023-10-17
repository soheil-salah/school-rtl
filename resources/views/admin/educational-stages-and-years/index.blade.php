<x-admin-app-layout>

    @push('title')
    <title>المراحل التعليمية</title>
    @endpush

    @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    @endpush

    <x-breadcrumb title="المراحل التعليمية" :breadcrumbs='["الصفحة الرئيسية" => "admin.dashboard", "المراحل التعليمية" => "active"]'></x-breadcrumb>


    <div class="row">
        <div class="col-12">
            <x-modal btnColor="btn-primary" btn="انشاء مرحلة تعليمية" modal="انشاء مرحلة تعليمية جديدة">
                <form id="create-educational-stage">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="education_stage_name" class="form-label">اسم المرحلة التعليمية</label>
                            <input type="text" class="form-control" name="education_stage_name" id="education_stage_name" required>
                        </div>

                        <div class="form-group">
                            <label for="thumbnail" class="form-label">
                                صورة تعريفية
                                <small class="font-weight-bold text-danger">اختياري</small>
                            </label>
                            <input type="file" class="form-control" name="thumbnail" id="thumbnail">
                        </div>

                        <hr>
                        
                        <div id="res"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-primary mr-2">انشاء</button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>
    
    
    <div class="row mt-5">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">المراحل التعليمية</div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-right">اسم المرحلة التعليمة</th>
                                <th class="text-right">عدد السنوات الدراسية</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($educationalStages as $educationalStage)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.educational-stage.show', $educationalStage->slug) }}">{{ $educationalStage->name }}</a>
                                </td>
                                <td>{{ $educationalStage->educationalYears->count() }}</td>
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
        <!-- /.col-xl-12 -->
    </div>

    @push('scripts')
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.repeater.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            
            $('#dataTables-example').DataTable({
                responsive: true,
                drawCallback: function () {
                    $('#dataTables-example_wrapper .row:last-child').addClass('mb-1 align-items-baseline');
                }
            });
        
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
                            title: 'يتم انشاء مرحلة تعليمية جديدة .... برجاء الانتظار',
                            showConfirmButton : false,
                        });
        
                    },
                    success : (data) => {
        
                        Swal.fire({
                            icon: 'success',
                            title: 'تم انشاء مرحلة تعليمية جديدة',
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
        });
    </script>
    @endpush
</x-admin-app-layout>