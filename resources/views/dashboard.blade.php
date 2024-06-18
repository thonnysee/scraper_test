<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight center" style="text-align: center" >
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form  method="GET" action="{{ route('scrape_site') }}">
                        @csrf
                        <div class="d-flex justify-content-center">
                            <div class="input-group">
                                <input
                                  type="text"
                                  class="form-control"
                                  placeholder="Add new page"
                                  aria-label="Add new page"
                                  aria-describedby="button-addon1"
                                  name="url"
                                  id="url"
                                  required
                                /> 
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary" type="submit" id="button-addon1" data-mdb-ripple-color="dark">
                                    Scrape
                                </button>
                            </div>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">URL</th>
                                <th scope="col">Total of Links</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sites as $site)
                                <tr scope="row">
                                    <td>{{ $site->name }}</td>
                                    <td><a style="color: blue" href="{{ $site->url }}" target="_blank">{{ $site->url }}</a></td>
                                    <td>{{ $site->links->count() }}</td>
                                    <td>{{ $site->status }}</td>
                                    <td class="d-flex "> 
                                        <a type="button" class="btn btn-outline-primary" href="{{route('show_site', ['site' => $site->id])}}">View</a>
                                        <form action="{{route('delete_site', ['site' => $site->id])}}" method="post">
                                            <button class="btn btn-outline-danger" type="submit">Delete</button>
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                {{ $sites->links() }}             
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
