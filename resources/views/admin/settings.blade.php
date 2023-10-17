@extends('layouts.admin',[
    'title' => 'الاعدادات'
])

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/vendor/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>بيانات الادمن</h5>
            </div>
            <div class="card-body">
                <form id="update">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">الاسم</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ Auth::user()->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">البريد الالكتروني</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">تحديث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>كلمة السر</h5>
            </div>
            <div class="card-body">
                <form id="update-password">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="password">كلمة السر</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="********">
                        </div>
                        <div class="col-6">
                            <label for="confirm_password">تأكيد كلمة السر</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="********">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">تحديث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="{{ asset('admin/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script>
$(document).ready(function(){

    $("#update").on('submit', function(e){
        e.preventDefault();

        $.ajax({
            type : "POST",
            url : "{{ route('ajax.admin.settings.update') }}",
            data : new FormData(this),
            contentType : false,
            processData : false,
            cache : false,
            success : (data) => {

                Swal.fire({
                    icon: 'success',
                    title: 'تم تحديث البيانات',
                    html : data,
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }
        });
    });


    $("#update-password").on('submit', function(e){
        e.preventDefault();

        $.ajax({
            type : "POST",
            url : "{{ route('ajax.admin.settings.update.password') }}",
            data : new FormData(this),
            contentType : false,
            processData : false,
            cache : false,
            success : (data) => {

                Swal.fire({
                    icon: 'success',
                    title: 'تم تحديث البيانات',
                    html : data,
                    showCancelButton: false,
                    showConfirmButton: false
                }).then(() => {

                    location.reload();
                });
            },
            error: function(xhr, status, error) {
                var err = JSON.parse(xhr.responseText);
                
                Swal.fire({
                    icon: 'error',
                    title: 'حدث خطاء اثناء التحديث',
                    html : err.message,
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }
        });
    });
});
</script>
@endsection