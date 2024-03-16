<div>

    @extends('layouts.app')

    @section('content')
        <title>Call2Rice -Vendor Dashboard</title>
        <link rel="shortcut icon" href="{{ asset('images/img1.jpg') }}" type="image/x-icon">
        <div class="container">
            <h2>Call2Rice -Vendor Dashboard Page</h2>
        </div>
        <main class="main pages">
            @yield('vendor')
        </main>
    @endsection

</div>
