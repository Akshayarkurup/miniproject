<x-app-layout>
    <x-slot:head>
        Dashboard
    </x-slot:head>
    <div class="container">
        <div class="row m-4 p-4">
            <div class="col-md-4 m-2">
                <div class="p-3 bg-primary text-white text-center rounded shadow">
                    <h1>{{ $imageCount }}</h1>
                    <h5>Total Uploaded Images</h5>
                </div>
            </div>
            <div class="col-md-4 m-2">
                <div class="p-3 bg-info text-white text-center rounded shadow">
                    <h1>{{ $colorCount }}</h1>
                    <h5>Total Detected Colors</h5>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>