<x-admin-app-layout>
    
    @push('title')
    <title>الطلاب</title>
    @endpush

    @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/vanilla-datatables-editable/datatable.editable.min.css') }}">
    @endpush

    <x-breadcrumb title="الطلاب" :breadcrumbs='["الصفحة الرئيسية" => "admin.dashboard", "الطلاب" => "active"]'></x-breadcrumb>


    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered" id="editable-datatable">
                <thead>
                    <tr>
                        <th>اسم الطالب بالكامل</th>
                        <th>اسم ولي امر الطالب بالكامل</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->guardian[0]->name }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('assets/libs/vanilla-datatables-editable/datatable.editable.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script>
        $(document).ready(function () {

            $("#editable-datatable")
                .find("td:first")
                .focus();
            $(function () {
                $("#editable-datatable").DataTable({
                    "language": {
                        "search": "بحث",
                        "lengthMenu": "عرض _MENU_ نتائج",
                        "infoEmpty": "لا توجد نتائج متاحة",
                        "info": "عرض _PAGE_ من اصل _PAGES_",
                        "zeroRecords": "لا توجد اي نتائج لاي طلاب",
                        'paginate': {
                            'previous': 'السابق',
                            'next': 'التالي'
                        },
                    }
                });
            });
        });
    </script>
    @endpush

</x-admin-app-layout>