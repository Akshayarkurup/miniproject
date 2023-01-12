<x-app-layout>
    <x-slot:head>
        History
    </x-slot:head>

    <div class="py-12">
    
            @php
            if(Session::get('msg')){
                echo(Session::get('msg'));
                unset($_SESSION['msg']);
            }
            @endphp
    
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="row justify-content-center p-5">
                        @foreach($images as $key => $image)
                            <div class="col-5 p-2 m-4 border">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ asset('storage/'.$image->img) }}" width="100px" height="100px">
                                    </div>
                                    <div class="col-md-8">
                                        <h1 style="display: inline;">{{ $count[$key] }}</h1><h4 style="display: inline;"> Colors Detected</h4>
                                        <br>
                                        <h6>{{ $image->created_at }}</h6>
                                        <a style="text-decoration: none;" href="{{ route('showHistory',['id'=>$image->id]) }}">View more</a><br>
                                        <a style="text-decoration: none;" class="text-danger" href="{{ route('deleteHistory',['id'=>$image->id]) }}">delete</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
