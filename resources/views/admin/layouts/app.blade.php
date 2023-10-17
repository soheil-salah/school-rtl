<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    @stack('title')

    <link rel="shortcut icon" type="image/png" href="" />

    @if(App\Modules\Admins\Models\AdminSetting::where('admin_id', Auth::guard('admin')->user()->id)->first()->dark_mode == 1)
    <link rel="stylesheet" href="{{ asset('assets/css/style-dark.min.css') }}" />
    @else
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}" />
    @endif
    
    @stack('styles')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        
        <!-- Sidebar Start -->
        <x-admin.navs.sidebar>

            <x-admin.navs.sidebar-nav-small-cap title="القائمة"></x-navs.sidebar-nav-small-cap>

            <x-admin.navs.sidebar-item route="admin.dashboard" title="الصفحة الرئيسية" icon="home"></x-navs.sidebar-item>
            <x-admin.navs.sidebar-item route="admin.inqueries" title="الاستفسارات" icon="message-dots" class="{{ Route::current()->getName() == 'admin.inqueries.read' || Route::current()->getName() == 'admin.inqueries' ? 'active' : null }}"></x-navs.sidebar-item>
            <x-admin.navs.sidebar-item route="admin.admissions" title="القبول" icon="thumb-up"></x-navs.sidebar-item>
            <x-admin.navs.sidebar-item route="admin.gallery" title="معرض الصور" icon="album" class="{{ Route::current()->getName() == 'admin.gallery' || Route::current()->getName() == 'admin.gallery.show' ? 'active' : null }}"></x-navs.sidebar-item>
            <x-admin.navs.sidebar-item route="admin.board-members" title="اعضاء هئية التدرسي" icon="users" class="{{ Route::current()->getName() == 'admin.board-members' || Route::current()->getName() == 'admin.board-member.show' ? 'active' : null }}"></x-navs.sidebar-item>

            <x-admin.navs.sidebar-item route="admin.educational-stages-and-years" title="المراحل التعليمية" icon="list-details" class="{{ Route::current()->getName() == 'admin.educational-stages-and-years' || Route::current()->getName() == 'admin.educational-stage.show' ? 'active' : null }}"></x-navs.sidebar-item>
            
            @php
                $activeRoutes = [
                    'admin.guardians',
                    'admin.students',
                ];

                $active = in_array(Route::current()->getName(), $activeRoutes) ? 'active' : null;
            @endphp

            <x-admin.navs.sidebar-item-dropdown title="الطلبة و اولياء الامور" icon="user-star" :active="$active">

                <x-admin.navs.sidebar-item-dropdown-list title="الطلاب" route="admin.students"></x-admin.navs.sidebar-item-dropdown-list>
                <x-admin.navs.sidebar-item-dropdown-list title="اولياء الامور" route="admin.guardians"></x-admin.navs.sidebar-item-dropdown-list>

            </x-navs.sidebar-item-dropdown>
            
            <x-admin.navs.sidebar-item route="admin.terms-and-conditions" title="الشروط و الاحكام" icon="checklist"></x-navs.sidebar-item>
            <x-admin.navs.sidebar-item route="admin.policy" title="سياسة الموقع" icon="prison"></x-navs.sidebar-item>
            <x-admin.navs.sidebar-item route="admin.profile.edit" title="الاعدادات" icon="adjustments-cog"></x-navs.sidebar-item>
            <x-admin.navs.sidebar-item route="index" title="الموقع الرئيسي" target="blank" icon="world"></x-navs.sidebar-item>

        </x-navs.sidebar>
        <!--  Sidebar End -->

        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <x-admin.navs.header>

                <x-admin.navs.header-item route="admin.profile.edit" title="الاعدادات" icon="user-circle"></x-navs.header-item>
                
                <x-admin.navs.header-item route="admin.profile.edit" title="تغيير كلمة السر" icon="key"></x-navs.header-item>

                <x-admin.navs.header-item route="admin.profile.edit" title="تغيير الصورة" icon="photo-edit"></x-navs.header-item>

                @php
                    $adminSetting = App\Modules\Admins\Models\AdminSetting::where('admin_id', Auth::guard('admin')->user()->id)->first();

                    $mode = $adminSetting->dark_mode == "1" ? 'dark' : 'light';
                @endphp
                @if($adminSetting->dark_mode == 1)
                <x-admin.navs.header-item title="النظام النهاري" icon="sun" id="switch-mode" data-mode="{{$mode}}" style="cursor: pointer;"></x-navs.header-item>
                @else
                <x-admin.navs.header-item title="النظام الليلي" icon="moon" id="switch-mode" data-mode="{{$mode}}" style="cursor: pointer;"></x-navs.header-item>
                @endif

            </x-navs.header>
            <!--  Header End -->

            <div class="container-fluid">
                {{ $slot }}
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script>
        $("#switch-mode").on('click', function(e){
            e.preventDefault();

            var mode = $(this).data('mode');

            $.ajax({
                type : "POST",
                url : "{{ route('admin.profile.switch-mode') }}",
                data : {
                    "_token" : "{{ csrf_token() }}",
                    "mode" : mode,
                    "admin_id" : "{{ Auth::guard('admin')->user()->id }}"
                },
                success : function(){
                    location.reload();
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>