<x-app-layout>

    @push('title')
        <title>تواصل معنا - {{ config('app.name') }}</title>
    @endpush

    <div class="jumbotron text-center">
        <h1 class="display-3">تواصل معنا</h1>
        <p class="lead">{{ config('app.name') }}</p>
    </div>

    <form id="contactForm">
        <div class="row">
            <div class="col-lg-6 col-sm-6">
                <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control" required placeholder="اسمك بالكامل" />
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="form-group">
                    <input type="text" name="phone_number" id="phone_number" required class="form-control" placeholder="رقم الهاتف" />
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="form-group">
                    <input type="text" name="msg_subject" id="msg_subject" class="form-control" required placeholder="عنوان رسالتك" />
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="form-group">
                    <textarea name="message" class="form-control" id="message" cols="30" rows="5" required placeholder="اكتب رسالتك"></textarea>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <button type="b" class="btn btn-success" id="send-btn">
                    ارسال
                </button>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        $("#send-btn").on('click', function(e){
            e.preventDefault();

            var name = $("#name").val();
            var email = $("#email").val();
            var msg_subject = $("#msg_subject").val();
            var phone_number = $("#phone_number").val();
            var message = $("#message").val();

            $("#name").attr("disabled", false);
            $("#email").attr("disabled", false);
            $("#msg_subject").attr("disabled", false);
            $("#phone_number").attr("disabled", false);
            $("#message").attr("disabled", false);
            $("#send-btn").prop("disabled", false);

            $.ajax({
                type: "POST",
                url: "{{ route('send-inquery') }}",
                data: {
                    "_token" : "{{ csrf_token() }}",
                    "name" : name,
                    "email" : email,
                    "msg_subject" : msg_subject,
                    "phone_number" : phone_number,
                    "message" : message,
                },
                beforeSend : () => {

                    $("#name").attr("disabled", true);
                    $("#email").attr("disabled", true);
                    $("#msg_subject").attr("disabled", true);
                    $("#phone_number").attr("disabled", true);
                    $("#message").attr("disabled", true);
                    $("#send-btn").prop("disabled", true);
                    $("#send-btn").html("يتم الارسال");

                },
                success : function(text){

                    $("#send-btn").html('تم الارسال');
                    $("#msgSubmit").html(text);
                }
            });
        });
    </script>
    @endpush
</x-app-layout>