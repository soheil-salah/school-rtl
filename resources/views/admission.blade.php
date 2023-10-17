<x-app-layout>

    @push('title')
        <title>القبول - {{ config('app.name') }}</title>
    @endpush

    <div class="jumbotron text-center">
        <h1 class="display-3">القبول</h1>
        <p class="lead">{{ config('app.name') }}</p>
    </div>

    <x-forms.form
        submit
        submitTitle="حفظ"
        submitAttrs="class='btn btn-success float-left mx-1 mb-5'"
        reset
        resetTitle="مسح"
        resetAttrs="class='btn btn-warning float-left mx-1 mb-5'"
        class="text-right my-5"
        id="submitAdmission">

        <div class="row">
            <div class="col-12">
                <h3>بيانات ولي الامر</h3>
                <hr>
            </div>
            <div class="col-6">
                <x-forms.input label="guardian_name" title="اسم ولي الامر بالكامل" id="guardian_name" name="guardian_name" required></x-forms.input>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <x-forms.input label="guardian_phone" title="رقم الهاتف" id="guardian_phone" name="guardian_phone" pattern="[0-9]+" required></x-forms.input>
            </div>

            <div class="col-6">
                <x-forms.input label="email" title="البريد الالكتروني" id="email" name="email" type="email">
                    <small class="text-danger font-weight-bold">اختياري</small>
                </x-forms.input>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-12">
                <h3>بيانات الطالب</h3>
                <hr>
            </div>
            <div class="col-6">
                <x-forms.input label="student_name" title="اسم الطالب بالكامل" id="student_name" name="student_name" required></x-forms.input>
            </div>

            <div class="col-6">
                <x-forms.select label="educational_year" title="السنة الدراسية" id="educational_year" name="educational_year" required>
                    @foreach($educationalYears as $educationalYear)
                    <option value="{{ $educationalYear->id }}">{{ $educationalYear->name }}</option>
                    @endforeach
                </x-forms.select>
            </div>
        </div>

    </x-forms.form>

    @push('scripts')
    <script>
        $("#submitAdmission").on('submit', function(e){
            e.preventDefault();

            $.ajax({
                type : "POST",
                url : "{{ route('send-admission') }}",
                data : new FormData(this),
                contentType : false,
                processData : false,
                cache : false,
                beforeSend: function(){

                    $("#submitAdmission").empty();
                },
                success : function(data){

                    
                    $("#submitAdmission").html(`
                    <div class="jumbotron text-center">
                        <i class="fa fa-check text-success" style="font-size: 100px;"></i>
                        <h1 class="mb-3">تم ارسال ملف طلبك بنجاح</h1>
                        <hr>
                        <div id="submit-admission-res"></div>
                        <p>لقد تم ارسال طلبك الينا سوف يتم التواصل معك في اقرب وقت ممكن</p>
                    </div>`);

                    $("#submit-admission-res").html(data);
                }
            });
        });
    </script>
    @endpush

</x-app-layout>