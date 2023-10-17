<x-admin-app-layout>
    @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/toastr/toastr.min.css') }}">
    @endpush


    <x-breadcrumb title="الاعدادات" :breadcrumbs='["الصفحة الرئيسية" => "admin.dashboard", "الاعدادات" => "active"]'></x-breadcrumb>

    <div class="card">
        <ul class="nav nav-pills user-profile-tab" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-4" id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#pills-account" type="button" role="tab" aria-controls="pills-account" aria-selected="true">
                    <i class="ti ti-user-circle me-2 fs-6"></i>
                    <span class="d-none d-md-block">معلوماتي الشخصية</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-4" id="update-password-tab" data-bs-toggle="pill" data-bs-target="#update-password" type="button" role="tab" aria-controls="update-password" aria-selected="true">
                    <i class="ti ti-key  me-2 fs-6"></i>
                    <span class="d-none d-md-block">تحديث كلمة السر</span>
                </button>
            </li>
        </ul>
        <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab" tabindex="0">
                    <div class="row">
                        <div class="col-12">
                            @include('admin.profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="update-password" role="tabpanel" aria-labelledby="update-password-tab" tabindex="0">
                    <div class="row">
                        <div class="col-12">
                            @include('admin.profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('assets/libs/toastr/toastr.min.js') }}"></script>

    @if (session('status') === 'profile-updated')
    <script>
        toastr.success("تم تعديل بياناتك الشخصية");
    </script>
    @endif

    @if (session('status') === 'password-updated')
    <script>
        toastr.success("تم تأكيد كلمة السر");
    </script>
    @endif
    @endpush

</x-admin-app-layout>
