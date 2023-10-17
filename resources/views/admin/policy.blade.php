<x-admin-app-layout>

    @push('title')
    <title>سياسة المدرسة</title>
    @endpush

    @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
    @endpush

    <div class="justify-content-center row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h5>شروط و احكام المدرسة</h5>
                </div>
                <div class="card-body">
                    <textarea name="editor1" id="policy">{!! $policy == null ? null : $policy->content !!}</textarea>

                    <hr>

                    <div class="modal-footer">
                        <button class="btn btn-success font-weight-bold" id="update-policy">تحديث سياسة المدرسة</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script>
        CKEDITOR.replace( 'editor1' );
    
        $("#update-policy").on('click', function(e){
            e.preventDefault();
    
            var policy = CKEDITOR.instances['policy'].getData();
    
            $.ajax({
                type : "POST",
                url : "{{ route('admin.policy.update') }}",
                data : {
                    "_token" : "{{ csrf_token() }}",
                    "policy" : policy
                },
                success : (data) => {
    
                    Swal.fire({
                        icon: 'success',
                        title: 'تم تحديث سياسة المدرسة',
                        html : data,
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                }
            });
        });
    </script>
    @endpush

</x-admin-app-layout>