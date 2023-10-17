<x-admin-app-layout>

    @push('title')
    <title>معرض الصور - {{ $album->album_name }}</title>
    @endpush

    @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/dropzone/dist/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
    @endpush

    <x-breadcrumb title="{{ $album->album_name }}" :breadcrumbs='["الصفحة الرئيسية" => "admin.dashboard", "معرض الصور" => "admin.gallery", "$album->album_name" => "active"]'></x-breadcrumb>

    <button class="btn btn-danger ml-2" id="delete-all-photos" data-album-id="{{ $album->id }}">مسح جميع الصور</button>
    
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-info ml-2" data-bs-toggle="modal" data-bs-target="#galleryThumbnailModal">
        تعديل / مسح الصورة التعريفية
    </button>
    
    <!-- Modal -->
    <div class="modal fade" id="galleryThumbnailModal" tabindex="-1" role="dialog" aria-labelledby="galleryThumbnailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="galleryThumbnailModalLabel">الصورة التعريقية للالبوم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="update-album-thumbnail">
                    {{ csrf_field() }}
                    <input type="hidden" name="album_id" value="{{ $album->id }}">
                    <div class="modal-body">
                        <img src="{{ asset('uploads/gallery-album/'.$album->slug.'/thumbnail/'.$album->thumbnail) }}" class="img-fluid" alt="">
                        <hr>
                        <div class="form-group">
                            <label for="thumbnail">الصورة الجديد</label>
                            <input type="file" class="form-control" name="thumbnail" id="thumbnail" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
                        <button type="submit" class="btn btn-primary">تحديث</button>
                        @if($album->thumbnail != null)
                        <button type="button" class="btn btn-danger" id="delete-thumbnail" data-album-id="{{ $album->id }}">مسح</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($album->isPublic == 0)
    <button class="btn btn-success" id="publish-album" data-album-id="{{ $album->id }}">نشر الالبوم</button>
    @else
    <button class="btn btn-warning font-weight-bold" id="unpublish-album" data-album-id="{{ $album->id }}">اخفاء الالبوم عن العامة</button>
    @endif
    
    <hr>
    
    <div class="row justify-content-center">
        <div class="col-8">
            <form action="{{ route('admin.ajax.admin.gallery.photos.upload') }}" method="POST" enctype="multipart/form-data" class="dropzone" id="dropzone">
                {{ csrf_field() }}
                <input type="hidden" name="album_id" value="{{ $album->id }}">
            </form>
        </div>
    </div>
    
    
    <hr>
    
    <div class="row mt-5">
        @foreach($album->photos as $photo)
        <div class="col-lg-4 col-12 mb-5">
            <div class="card-header">
                <button class="btn btn-danger btn-sm font-weight-bold delete-photo" data-photo-id="{{ $photo->id }}">مسح</button>
            </div>
            <div class="card-body">
                <img src="{{ asset('uploads/gallery-album/'.$album->slug.'/'.$photo->image_name) }}" class="img-fluid" alt="">
            </div> 
        </div>
        @endforeach
    </div>
    
    @push('scripts')
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
    
    Dropzone.options.dropzone = {
      // Note: using "function()" here to bind `this` to
      // the Dropzone instance.
      init: function() {
        this.on("complete", function () {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                location.reload();
            }
        });
      }
    };
    
    $("#update-album-thumbnail").on('submit', function(e){
        e.preventDefault();
    
        $.ajax({
            type : "POST",
            url : "{{ route('admin.ajax.admin.gallery.album.update.thumbnail') }}",
            data : new FormData(this),
            contentType : false,
            processData : false,
            cache : false,
            beforeSend : () => {
    
                $("#galleryThumbnailModal").modal('hide');
    
                Swal.fire({
                    icon: 'info',
                    title: 'يتم تحديث صورة الالبوم .... برجاء الانتظار',
                    showConfirmButton : false,
                });
    
            },
            success : (data) => {
    
                Swal.fire({
                    icon: 'success',
                    title: 'تم تحديث صورة الالبوم',
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
            url : "{{ route('admin.ajax.admin.gallery.album.delete.thumbnail') }}",
            data : {
                "_token" : "{{ csrf_token() }}",
                "album_id" : $(this).data('album-id') 
            },
            beforeSend : () => {
    
                $("#galleryThumbnailModal").modal('hide');
    
                Swal.fire({
                    icon: 'info',
                    title: 'يتم مسح الصورة التعريفية .... برجاء الانتظار',
                    showConfirmButton : false,
                });
    
            },
            success : (data) => {
    
                Swal.fire({
                    icon: 'success',
                    title: 'تم مسح الصورة التعريفية',
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

    $(".delete-photo").on('click', function(e){
        e.preventDefault();

        var photo_id = $(this).data('photo-id');

        $.ajax({
            type : "POST",
            url : "{{ route('admin.ajax.admin.gallery.album.delete-photo') }}",
            data : {
                "_token" : "{{ csrf_token() }}",
                "photo_id" : photo_id, 
            },
            beforeSend : () => {
    
                $("#galleryThumbnailModal").modal('hide');
    
                Swal.fire({
                    icon: 'info',
                    title: 'يتم مسح الصورة .... برجاء الانتظار',
                    showConfirmButton : false,
                });
    
            },
            success : (data) => {
    
                Swal.fire({
                    icon: 'success',
                    title: 'تم مسح الصورة',
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
    
    $("#delete-all-photos").on('click', function(e){
        e.preventDefault();
    
        $.ajax({
            type : "POST",
            url : "{{ route('admin.ajax.admin.gallery.album.delete-all-photos') }}",
            data : {
                "_token" : "{{ csrf_token() }}",
                "album_id" : $(this).data('album-id') 
            },
            beforeSend : () => {
    
                Swal.fire({
                    icon: 'info',
                    title: 'يتم مسح جميع الصور من الالبوم .... برجاء الانتظار',
                    showConfirmButton : false,
                });
    
            },
            success : (data) => {
    
                Swal.fire({
                    icon: 'success',
                    title: 'تم مسح جميع الصور من الالبوم',
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
    
    $("#publish-album").on('click', function(e){
        e.preventDefault();
    
        $.ajax({
            type : "POST",
            url : "{{ route('admin.ajax.admin.gallery.album.publish') }}",
            data : {
                "_token" : "{{ csrf_token() }}",
                "album_id" : $(this).data('album-id') 
            },
            beforeSend : () => {
    
                $("#createNewAlbumModal").modal('hide');
    
                Swal.fire({
                    icon: 'info',
                    title: 'يتم نشر الالبوم .... برجاء الانتظار',
                    showConfirmButton : false,
                });
    
            },
            success : (data) => {
    
                Swal.fire({
                    icon: 'success',
                    title: 'تم نشر الالبوم',
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
    
    $("#unpublish-album").on('click', function(e){
        e.preventDefault();
    
        $.ajax({
            type : "POST",
            url : "{{ route('admin.ajax.admin.gallery.album.unpublish') }}",
            data : {
                "_token" : "{{ csrf_token() }}",
                "album_id" : $(this).data('album-id') 
            },
            beforeSend : () => {
    
                $("#createNewAlbumModal").modal('hide');
    
                Swal.fire({
                    icon: 'info',
                    title: 'يتم اخفاء الالبوم عن العامة .... برجاء الانتظار',
                    showConfirmButton : false,
                });
    
            },
            success : (data) => {
    
                Swal.fire({
                    icon: 'success',
                    title: 'تم اخفاء الالبوم',
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
