<x-app-layout>
    <x-slot:head>
        Profile
    </x-slot:head>

    <div class="container p-3">
            <div class="row border m-3 text-center text-md-left">
                <div class="col-md-3 avathar">
                    <img src="{{ asset('assets/images/user.jpg') }}" alt="avatar" width="200px" height="200px">
                </div>
                <div class="col-md-6 pt-5 details">
                    <h2>{{ Auth::user()->name }}</h2>
                    <h6>{{ Auth::user()->email }}</h6>
                    <h6>{{ Auth::user()->mobile }}</h6>
                </div>
            </div>
    </div>
</x-app-layout>