<x-admin-app-layout>

    @push('title')
    <title>اعضاء هيئة التدريس</title>
    @endpush

    @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
    @endpush

    <x-breadcrumb title="اعضاء هيئة التدريس" :breadcrumbs='["الصفحة الرئيسية" => "admin.dashboard", "اعضاء هيئة التدريس" => "active"]'></x-breadcrumb>

    <div class="row">
        <div class="col-12">
            <x-modal btn="اضافةعضو" modal="اضافة عضو جديد" size="modal-lg">
                <form id="add-board-member">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-6 mb-3">
                                <label for="board_member_name" class="form-label">اسم العضو</label>
                                <input type="text" class="form-control" name="board_member_name" id="board_member_name" required>
                            </div>
                            <div class="col-6">
                                <label for="board_member_title" class="form-label">المسمي الوظيفي</label>
                                <input type="text" class="form-control" name="board_member_title" id="board_member_title" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="board_member_phone" class="form-label">رقم الهاتف</label>
                            <input type="number" class="form-control" name="board_member_phone" id="board_member_phone" pattern="[0-9]+" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="board_member_image" class="form-label">صورة العضو</label>
                            <input type="file" class="form-control" name="board_member_image" id="board_member_image" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="board_member_title" class="form-label">
                                نبذة عن العضو
                                <small class="text-danger font-weight-bold" id="board_member_title_error"></small>
                            </label>
                            <textarea name="about_board_member" id="about_board_member" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-primary" id="create-board-member">
                            اضافة
                            <i class="fa fa-plus-circle"></i>
                        </button>
                    </div>
                </form>
            </x-modal>

            
        </div>
    </div>
    <div class="row mt-5">
        @foreach($boardMembers as $boardMember)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ $boardMember->name }}</h5>
                </div>
                <div class="card-body">
                    @if($boardMember->image != null)
                    <img src="{{ asset('uploads/board-members/teachers/'.$boardMember->slug.'/'.$boardMember->image) }}" class="img-fluid" alt="">
                    @else
                    <img src="{{ asset('assets/images/profile/user.png') }}" class="img-fluid" alt="">
                    @endif
                </div>
                <div class="card-footer text-left">
                    <a href="{{ route('admin.board-member.show', $boardMember->slug) }}" class="btn btn-info btn-sm font-weight-bold">المزيد</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @push('scripts')
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
    CKEDITOR.replace( 'about_board_member' );

    $("#add-board-member").on('submit', function(e){
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
                url : "{{ route('admin.ajax.board-member.create') }}",
                data : new FormData(this),
                contentType : false,
                processData : false,
                cache : false,
                beforeSend : function(){

                    Swal.fire({
                        icon: 'info',
                        title: 'يتم اضافة عضو ... برجاء الانتظار',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success : (data) => {

                    Swal.fire({
                        icon: 'success',
                        title: 'تم اضافة عضو',
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
    </script>
    @endpush

</x-admin-app-layout>