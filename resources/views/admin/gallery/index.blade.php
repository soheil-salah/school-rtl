<x-admin-app-layout>

    @push('title')
    <title>معرض الصور</title>
    @endpush

    @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
    <style>
    /* Styles for wrapping the search box */

    .main {
        width: 50%;
        margin: 50px auto;
    }

    /* Bootstrap 4 text input with search icon */

    .has-search .form-control {
        padding-right: 2.375rem;
    }

    .has-search .form-control-feedback {
        position: absolute;
        z-index: 2;
        display: block;
        width: 2.375rem;
        height: 2.375rem;
        line-height: 2.375rem;
        text-align: center;
        pointer-events: none;
        color: #aaa;
    }
    </style>
    @endpush

    <x-breadcrumb title="معرض الصور" :breadcrumbs='["الصفحة الرئيسية" => "admin.dashboard", "معرض الصور" => "active"]'></x-breadcrumb>

    <div class="row">
        <div class="col-12">

            <!-- Gallery Album Modal -->
            <x-modal btn="انشاء البوم صور" icon='<i class="fa fa-plus"></i>' modal="انشاء البوم جديد">
                <form id="create-new-album">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="album">اسم الالبوم</label>
                            <input type="text" class="form-control" name="album" id="album" required>
                        </div>

                        <div class="form-group">
                            <label for="thumbnail">
                                صورة تعريفية
                                <small class="font-weight-bold text-danger">اختياري</small>
                            </label>
                            <input type="file" class="form-control" name="thumbnail" id="thumbnail">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-primary mr-2">انشاء</button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>
    
    @if($albums->count() > 0)
    <div class="main">
        <!-- Actual search box -->
        <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" id="input" placeholder="بحث عن الالبوم" autocomplete="off">
        </div>
    </div>
    
    <div class="row mt-5">
        @foreach($albums as $album)
        <div data-tag="{{ $album->album_name }}" class="col-lg-4 col-12 album">
            <div class="card" style="border: none;">
                <div class="card-header">
                    <h5 class="float-right album-name-{{$album->id}}" data-album-id="{{ $album->id }}" contenteditable="true">
                        {{ $album->album_name }}
                    </h5>
                    <div class="float-left">
                        <button class="btn btn-success btn-sm update-album-name" data-album-id="{{ $album->id }}">تحديث</button>
                        <button class="btn btn-danger btn-sm delete-album" data-album-id="{{ $album->id }}">مسح</button>
                    </div>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('admin.gallery.show', $album->slug) }}" style="text-decoration: none;">
                        @if($album->thumbnail == null)
                        <i class="fa fa-folder" style="font-size: 200px;"></i>
                        @else
                        <img src="{{ asset('uploads/gallery-album/'.$album->slug.'/thumbnail/'.$album->thumbnail) }}" class="img-fluid" alt="">
                        @endif
                        <p>{{ $album->photos->count() }} صورة</p>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif 
    
    @push('scripts')
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    @if($albums->count() > 0)
    <script>
    let input = document.getElementById('input');
        let animalDivs = document.querySelectorAll('.album');
    
        input.addEventListener('input', function(e) {
            const term = this.value.toLowerCase();
            animalDivs.forEach(function(div) {
                const animal = div.dataset.tag.toLocaleLowerCase();
                div.hidden = !animal.includes(term)
            });
        });
    </script>
    @endif
    <script>
        $("#create-new-album").on('submit', function(e){
            e.preventDefault();
    
            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.admin.gallery.album.create') }}",
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
    
        $(".delete-album").on('click', function(e){
            e.preventDefault();
    
            var album_id = $(this).data('album-id');
    
            Swal.fire({
                title: 'هل انت متاكد من مسح هذا الالبوم',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'نعم',
                denyButtonText: `لا`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
    
                    $.ajax({
                        type : "POST",
                        url : "{{ route('admin.ajax.admin.gallery.album.delete') }}",
                        data : {
                            "_token" : "{{ csrf_token() }}",
                            "album_id" : album_id,
                        },
                        beforeSend : () => {
    
                            $("#createNewAlbumModal").modal('hide');
    
                            Swal.fire({
                                icon: 'info',
                                title: 'يتم مسح الالبوم .... برجاء الانتظار',
                                showConfirmButton : false,
                            });
    
                        },
                        success : (data) => {
    
                            Swal.fire({
                                icon: 'success',
                                title: 'تم مسح الالبوم',
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
    
                } else if (result.isDenied) {
                    Swal.fire('لم يتم مسح الالبوم', '', 'info')
                }
            })
            
        });
    
        $(".update-album-name").on('click', function(){
           
            var album_id = $(this).data('album-id');
            var album_name = $(".album-name-"+album_id).text();
    
            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.admin.gallery.album.update.title') }}",
                data : {
                    "_token" : "{{ csrf_token() }}",
                    "album_id" : album_id,
                    "album_name" : album_name,
                },
                beforeSend : () => {
    
                $("#createNewAlbumModal").modal('hide');
    
                    Swal.fire({
                        icon: 'info',
                        title: 'يتم تحديث اسم الالبوم .... برجاء الانتظار',
                        showConfirmButton : false,
                    });
    
                },
                success : (data) => {
    
                    Swal.fire({
                        icon: 'success',
                        title: 'تم تحديث اسم الالبوم',
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
    </script>
    @endpush

</x-admin-app-layout>


