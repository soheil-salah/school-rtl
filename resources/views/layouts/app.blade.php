<!doctype html>
<html lang="ar" dir="rtl">
<head>
    @stack('title')

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @stack('meta')

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    @stack('styles')
</head>
<body>

    <x-navs.navbar>

        <x-navs.nav-item title="الرئيسية" route="index" class="{{ Route::current()->getName() == 'index' ? 'active' : null  }}"></x-navs.nav-item>
        <x-navs.nav-item title="من نحن" route="about" class="{{ Route::current()->getName() == 'about' ? 'active' : null  }}"></x-navs.nav-item>
        <x-navs.nav-item title="القبول" route="admission" class="{{ Route::current()->getName() == 'admission' ? 'active' : null  }}"></x-navs.nav-item>
        <x-navs.nav-item title="اعضاء هئية التدريس" route="board-members" class="{{ Route::current()->getName() == 'board-members' || Route::current()->getName() == 'board-member.show' ? 'active' : null  }}"></x-navs.nav-item>
        <x-navs.nav-item title="معرض الصور" route="galleries" class="{{ Route::current()->getName() == 'galleries' || Route::current()->getName() == 'gallery' ? 'active' : null  }}"></x-navs.nav-item>
        <x-navs.nav-item title="اتصل بنا" route="contact" class="{{ Route::current()->getName() == 'contact' ? 'active' : null  }}"></x-navs.nav-item>

        {{-- <x-navs.nav-item-dropdown title="Dropdown 1">

            <x-navs.dropdown-item title="Sub Menu"></x-navs.dropdown-item>
            <x-navs.dropdown-item title="Sub Menu 2"></x-navs.dropdown-item>

        </x-navs.nav-item-dropdown> --}}
    </x-navs.navbar>

    <main class="container mt-5">
        {{ $slot }}
    </main>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
