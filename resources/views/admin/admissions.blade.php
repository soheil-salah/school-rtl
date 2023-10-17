<x-admin-app-layout>
    
    @push('title')
    <title>ملفات القبول</title>
    @endpush

    @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/vanilla-datatables-editable/datatable.editable.min.css') }}">
    @endpush

    <x-breadcrumb title="ملفات القبول" :breadcrumbs='["الصفحة الرئيسية" => "admin.dashboard", "ملفات القبول" => "active"]'></x-breadcrumb>


    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered" id="editable-datatable">
                <thead>
                    <tr>
                        <th>اسم ولي الامر بالكامل</th>
                        <th>اسم الطالب او الطلاب</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($admissions as $admission)
                <tr>
                    <td>{{ $admission->guardian->name }}</td>
                    <td>
                        <ol>
                        @foreach($admission->guardian->students as $student)
                            <li>{{ $student->name }}</li>
                        @endforeach
                        </ol>
                    </td>
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
                        "zeroRecords": "لا توجد اي نتائج لاي ملفات قبول",
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