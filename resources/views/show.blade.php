<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="text-align: center">
            {{ __($site->name) }}
        </h2>
    </x-slot>
    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">URL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($links as $link)
                                <tr scope="row">
                                    <td>{{ $link->name }}</td>
                                    <td><a style="color:blue" href="{{ $link->url }}" target="_blank">{{ $link->url }}</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                {{ $links->links() }}             
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
