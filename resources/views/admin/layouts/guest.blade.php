<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
    @isset($title)
        {{ $title }}
    @else
        {{ config('app.name') }}
    @endisset
    </title>
    <x-icon></x-icon>
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}" />
</head>
<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="{{ route('admin.dashboard') }}" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                <x-logo name="My School"></x-logo>
                            </a>
                            <form method="POST" action="{{ route('admin.login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">رقم الهاتف او البريد الالكتروني</label>
                                    <input type="email" class="form-control" id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">كلمة السر</label>
                                    <input type="password" class="form-control" id="password" type="password" name="password" required autocomplete="current-password">
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input primary" type="checkbox" value="" id="remember_me" name="remember" checked>
                                        <label class="form-check-label text-dark" for="remember_me">
                                        تذكرني
                                        </label>
                                    </div>
                                    <a class="text-primary fw-bold" href="javascript:void(0);">نسيت كلمة السر ؟</a>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">الدخول</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>