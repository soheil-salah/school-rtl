<x-admin-app-layout>
    @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/vanilla-datatables-editable/datatable.editable.min.css') }}">
    @endpush

    <x-breadcrumb title="الاستفسارات" :breadcrumbs='["الصفحة الرئيسية" => "admin.dashboard", "الاستفسارات" => "active"]'></x-breadcrumb>

    <div class="row">
        <div class="col-3">
            <div class="card border-0 zoom-in bg-success shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-checks text-light" style="font-size: 50px;"></i>
                        <p class="fw-semibold fs-3 text-light mb-1">المقروء</p>
                        <h5 class="fw-semibold text-light mb-0">{{ $count_unread_inqueries }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-3">
            <a href="{{ route('admin.inqueries') }}" class="card border-0 zoom-in bg-danger shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-message-dots text-light" style="font-size: 50px;"></i>
                        <p class="fw-semibold fs-3 text-light mb-1">الغير مقروء</p>
                        <h5 class="fw-semibold text-light mb-0" id="inquery-counter">{{ $count_read_inqueries }}</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h6 class="card-subtitle mb-3">Just click on word which you want to change and enter</h6>
            <table class="table table-striped table-bordered" id="editable-datatable">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>رقم الهاتف</th>
                        <th>عنوان الاستفسار</th>
                        <th>محتوي الاستفسار</th>    
                    </tr>
                </thead>
                <tbody>
                    @foreach($inqueies as $inquery)
                    <tr id="tr_{{$inquery->id}}">
                        <td>{{ $inquery->name }}</td>
                        <td>{{ $inquery->phone_number }}</td>
                        <td>{{ $inquery->msg_subject }}</td>
                        <td>
                            <button type="button" class="btn btn-success open-inquery-message" data-bs-toggle="modal" data-bs-target="#inqueryModal" data-inquery-id="{{ $inquery->id }}">
                                عرض محتوي الاستفسار
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Inquery Modal -->
    <div class="modal fade" id="inqueryModal" tabindex="-1" aria-labelledby="inqueryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div id="inquery-res"></div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script src="{{ asset('assets/libs/vanilla-datatables-editable/datatable.editable.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script>
        $(document).ready(function () {
            $('#inqueries').DataTable();

            $("#editable-datatable")
                .find("td:first")
                .focus();
            $(function () {
                $("#editable-datatable").DataTable();
            });

            $(".open-inquery-message").on('click', function(e){
                e.preventDefault();
                
                var inquery_id = $(this).data('inquery-id');

                $.ajax({
                    type : "POST",
                    url : "{{ route('admin.ajax.open-inquery-msg') }}",
                    data : {
                        "_token" : "{{ csrf_token() }}",
                        "inquery_id" : inquery_id,
                    },
                    beforeSend : function(){

                        $("#inqueryModalLabel").html('....');
                        $("#inquery-content").html('....');
                    },
                    success : function(data){

                        $("#inquery-res").html(data);
                    }
                });
            });
        });

        $(document).on('click', '.read-as-mark', function(e){
            e.preventDefault();

            var inquery_id = $(this).data('inquery-id');

            $.ajax({
                type : "POST",
                url : "{{ route('admin.ajax.mark-msg-as-read') }}",
                data : {
                    "_token" : "{{ csrf_token() }}",
                    "inquery_id" : inquery_id,
                },
                success : function(data){

                    $("#inquery-counter-res").html(data);
                    $("#inqueryModal").modal('hide');
                    $("#tr_"+inquery_id).remove();
                }
            });
                
        });
        </script>
    @endpush
</x-admin-app-layout>
