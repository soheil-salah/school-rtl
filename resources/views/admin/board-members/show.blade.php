<x-admin-app-layout>

    @push('title')
    <title>اعضاء هيئة التدريس - {{ $boardMember->name }}</title>
    @endpush

    @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
    @endpush

    <x-breadcrumb title="{{ $boardMember->name }}" :breadcrumbs='["الصفحة الرئيسية" => "admin.dashboard", "اعضاء هيئة التدريس" => "admin.board-members",  "$boardMember->name" => "active"]'></x-breadcrumb>

    <div class="row mt-5">
        <div class="col-lg-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="float-right">
                        <i class="fa fa-user"></i>
                        بيانات العضو
                    </h5>
                    @if($boardMember->isHidden == 1)
                    <button class="btn btn-success btn-sm font-weight-bold float-left" id="publish-board-membership" data-board-memeber-id="{{ $boardMember->id }}">نشر العضوية</button>
                    @else
                    <button class="btn btn-danger btn-sm font-weight-bold float-left" id="suspend-board-membership" data-board-memeber-id="{{ $boardMember->id }}">ايقاف العضوية</button>
                    @endif
                </div>
                <div class="card-body">
                    <form id="update-board-member-info">
                        {{ csrf_field() }}
                        <input type="hidden" name="board_member_id" value="{{ $boardMember->id }}">
                        <div class="form-group row">
                            <div class="col-6 mb-3">
                                <label for="board_member_name" class="form-label">اسم العضو</label>
                                <input type="text" class="form-control" name="board_member_name" id="board_member_name" value="{{ $boardMember->name }}" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="board_member_title" class="form-label">المسمي الوظيفي</label>
                                <input type="text" class="form-control" name="board_member_title" id="board_member_title" value="{{ $boardMember->title }}" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="board_member_phone" class="form-label">رقم الهاتف</label>
                            <input type="number" class="form-control" name="board_member_phone" id="board_member_phone" value="{{ $boardMember->phone }}" pattern="[0-9]+" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="board_member_title" class="form-label">
                                نبذة عن العضو
                                <small class="text-danger font-weight-bold" id="board_member_title_error"></small>
                            </label>
                            <textarea name="about_board_member" id="about_board_member" required>{!! $boardMember->about !!}</textarea>
                        </div>

                        <div class="modal-footer mb-3">
                            <button type="submit" class="btn btn-warning btn-sm font-weight-bold ml-2">تحديث بيانات العضو</button>
                            <button type="button" class="btn btn-danger btn-sm font-weight-bold" id="delete-board-member" data-board-memeber-id="{{ $boardMember->id }}">مسح العضو</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        <i class="fa fa-image"></i>
                        صورة العضو
                    </h5>
                </div>
                <form id="update-image">
                    {{ csrf_field() }}
                    <input type="hidden" name="board_member_id" value="{{ $boardMember->id }}">
                    <div class="card-body">
                        <p>الصورة الحالية : </p>
                        @if($boardMember->image != null)
                        <img src="{{ asset('uploads/board-members/teachers/'.$boardMember->slug.'/'.$boardMember->image) }}" class="img-fluid" alt="">
                        @else
                        <img src="{{ asset('assets/images/profile/user.png') }}" class="img-fluid" alt="">
                        @endif

                        <hr>

                        <div class="form-group">
                            <label for="board_member_image">الصورة الجديدة</label>
                            <input type="file" class="form-control" name="board_member_image" id="board_member_image" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if($boardMember->image == null)
                        <button type="submit" class="btn btn-success btn-sm font-weight-bold ml-2">رفع صورة جديدة</button>
                        @else
                        <button type="submit" class="btn btn-warning btn-sm font-weight-bold ml-2">تحديث الصورة</button>
                        <button type="button" class="btn btn-danger btn-sm font-weight-bold" id="delete-image" data-board-memeber-id="{{ $boardMember->id }}">مسح الصورة</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'about_board_member' );
        
        $("#update-board-member-info").on('submit', function(e){
            e.preventDefault();
        
            var about_board_member = CKEDITOR.instances['about_board_member'].getData();
        
            if(about_board_member == ''){
        
                $("#board_member_title_error").html('من فضلك اكنب نبذة عن العضو ');
        
            }else{
        
                for (var i in CKEDITOR.instances) {
                    CKEDITOR.instances[i].updateElement();
                }
        
                $.ajax({
                    type : "POST",
                    url : "{{ route('admin.ajax.board-member.update.info') }}",
                    data : new FormData(this),
                    contentType : false,
                    processData : false,
                    cache : false,
                    beforeSend : function(){
        
                        Swal.fire({
                            icon: 'info',
                            title: 'يتم تحديث بيانات العضو ... برجاء الانتظار',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    },
                    success : (data) => {
        
                        Swal.fire({
                            icon: 'success',
                            title: 'تم تحديث بيانات العضو',
                            html : data,
                            showCancelButton: false,
                            showConfirmButton: false
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
            }
        });
        
        $("#update-image").on('submit', function(e){
            e.preventDefault();
        
            var about_board_member = CKEDITOR.instances['about_board_member'].getData();
        
            if(about_board_member == ''){
        
                $("#board_member_title_error").html('من فضلك اكنب نبذة عن العضو ');
        
            }else{
        
                for (var i in CKEDITOR.instances) {
                    CKEDITOR.instances[i].updateElement();
                }
        
                $.ajax({
                    type : "POST",
                    url : "{{ route('admin.ajax.board-member.update.image') }}",
                    data : new FormData(this),
                    contentType : false,
                    processData : false,
                    cache : false,
                    beforeSend : function(){
        
                        Swal.fire({
                            icon: 'info',
                            title: 'يتم تحديث صورة العضو ... برجاء الانتظار',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    },
                    success : (data) => {
        
                        Swal.fire({
                            icon: 'success',
                            title: 'تم تحديث صورة العضو',
                            html : data,
                            showCancelButton: false,
                            showConfirmButton: false
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
            }
        });
        
        $("#delete-image").on('click', function(e){
            e.preventDefault();
        
            var board_memeber_id = $(this).data('board-memeber-id');
        
            Swal.fire({
                title: 'هل انت متاكد من انك تريد مسح الصورة',
                text: "تحذير : لن يمكنك استعادة الصورة مرة اخري",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'لا',
                confirmButtonText: 'نعم موافق'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type : "POST",
                        url : "{{ route('admin.ajax.board-member.delete.image') }}",
                        data : {
                            "_token" : "{{ csrf_token() }}",
                            "board_memeber_id" : board_memeber_id,
                        },
                        beforeSend : function(){
                
                            Swal.fire({
                                icon: 'info',
                                title: 'يتم مسح صورة العضو ... برجاء الانتظار',
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                        },
                        success : (data) => {
                
                            Swal.fire({
                                icon: 'success',
                                title: 'تم مسح صورة العضو',
                                html : data,
                                showCancelButton: false,
                                showConfirmButton: false
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
                }
            })
        });
        
        $("#publish-board-membership").on('click', function(e){
            e.preventDefault();
        
            var board_memeber_id = $(this).data('board-memeber-id');
          
            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.board-member.publish') }}",
                data : {
                    "_token" : "{{ csrf_token() }}",
                    "board_memeber_id" : board_memeber_id,
                },
                beforeSend : function(){
        
                    Swal.fire({
                        icon: 'info',
                        title: 'يتم نشر العضوية ... برجاء الانتظار',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success : (data) => {
        
                    Swal.fire({
                        icon: 'success',
                        title: 'تم نشر العضوية',
                        html : data,
                        showCancelButton: false,
                        showConfirmButton: false
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
        
        $("#suspend-board-membership").on('click', function(e){
            e.preventDefault();
        
            var board_memeber_id = $(this).data('board-memeber-id');
          
            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.board-member.suspend') }}",
                data : {
                    "_token" : "{{ csrf_token() }}",
                    "board_memeber_id" : board_memeber_id,
                },
                beforeSend : function(){
        
                    Swal.fire({
                        icon: 'info',
                        title: 'يتم ايقاف العضوية ... برجاء الانتظار',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success : (data) => {
        
                    Swal.fire({
                        icon: 'success',
                        title: 'تم ايقاف العضوية',
                        html : data,
                        showCancelButton: false,
                        showConfirmButton: false
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
        
        $("#delete-board-member").on('click', function(e){
            e.preventDefault();
        
            var board_memeber_id = $(this).data('board-memeber-id');
          
            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.board-member.delete') }}",
                data : {
                    "_token" : "{{ csrf_token() }}",
                    "board_memeber_id" : board_memeber_id,
                },
                beforeSend : function(){
        
                    Swal.fire({
                        icon: 'info',
                        title: 'يتم مسح العضو ... برجاء الانتظار',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success : (data) => {
        
                    Swal.fire({
                        icon: 'success',
                        title: 'تم مسح العضو',
                        html : data,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(() => {
        
                        location.replace("{{ route('admin.board-members') }}");
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
    </script>
    @endpush
</x-admin-app-layout>