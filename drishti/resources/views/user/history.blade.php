<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="p-5">
                        <div class="row mt-2 p-2 border">
                            <div class="col-4">
                                <img src="{{ asset('assets/images/hero_img.jpg') }}" width="100px" height="100px" >
                            </div>
                            <div class="col-8">
                                <h1>15</h2>
                                <small>04/11/22 4:00:00 PM</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
