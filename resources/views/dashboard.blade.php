<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Country Explorer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50">
                    {{ session('error') }}
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Search for a Country</h2>
                    <p class="mt-1 text-sm text-gray-600">Type a country name to fetch live data from the RestCountries API.</p>
                </header>
                <form method="GET" action="{{ route('dashboard') }}" class="mt-6 flex space-x-4">
                    <input type="text" name="search" placeholder="e.g., Sri Lanka" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full md:w-1/2" value="{{ request('search') }}">
                    <x-primary-button>Search</x-primary-button>
                </form>
            </div>

            @if(!empty($searchResult))
                @php $country = $searchResult; @endphp
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg flex flex-col md:flex-row items-center md:items-start gap-6">
                    <img src="{{ $country['flag_url'] }}" alt="Flag" class="w-32 h-auto border shadow-sm">
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold">{{ $country['name'] }}</h3>
                        <p class="text-gray-600"><strong>Capital:</strong> {{ $country['capital'] }}</p>
                        <p class="text-gray-600"><strong>Code:</strong> {{ $country['country_code'] }}</p>
                        
                        <form method="POST" action="{{ route('favourites.store') }}" class="mt-4 space-y-4">
                            @csrf
                            <input type="hidden" name="country_code" value="{{ $country['country_code'] }}">
                            <input type="hidden" name="name" value="{{ $country['name'] }}">
                            <input type="hidden" name="capital" value="{{ $country['capital'] }}">
                            <input type="hidden" name="flag_url" value="{{ $country['flag_url'] }}">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Add a Personal Note</label>
                                <textarea name="personal_note" rows="2" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" placeholder="e.g., I want to visit here next year!"></textarea>
                            </div>
                            <x-primary-button>Save to Favourites</x-primary-button>
                        </form>
                    </div>
                </div>
            @elseif(request()->has('search'))
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <p class="text-red-600">No country found for "{{ request('search') }}". Please try again.</p>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header class="mb-6">
                    <h2 class="text-lg font-medium text-gray-900">Your Saved Favourites</h2>
                </header>
                
                @if($savedCountries->isEmpty())
                    <p class="text-gray-500">You haven't saved any countries yet.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($savedCountries as $saved)
                            <div class="border rounded-lg p-4 flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex items-center gap-4 mb-3">
                                        <img src="{{ $saved->flag_url }}" alt="Flag" class="w-12 h-8 border">
                                        <div>
                                            <h4 class="font-bold text-lg">{{ $saved->name }}</h4>
                                            <p class="text-xs text-gray-500">Capital: {{ $saved->capital }}</p>
                                        </div>
                                    </div>
                                    
                                    <form method="POST" action="{{ route('favourites.update', $saved->id) }}" class="mt-2">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="personal_note" rows="2" class="w-full text-sm border-gray-300 rounded-md">{{ $saved->personal_note }}</textarea>
                                        <button type="submit" class="mt-1 text-sm text-indigo-600 hover:text-indigo-900">Update Note</button>
                                    </form>
                                </div>

                                <form method="POST" action="{{ route('favourites.destroy', $saved->id) }}" class="mt-4 text-right">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to remove this country?')">Remove</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>