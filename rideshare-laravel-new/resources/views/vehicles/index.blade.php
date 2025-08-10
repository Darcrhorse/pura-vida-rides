@extends('layouts.marketing')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Vehicles</h1>
        <a href="{{ route('vehicles.create') }}" class="bg-teal text-white py-2 px-4 rounded-md hover:bg-teal-600 transition-colors">
            Add Vehicle
        </a>
    </div>

    <div class="space-y-4">
        @forelse($vehicles as $v)
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-bold">{{ $v->year }} {{ $v->make }} {{ $v->model }}</h3>
                    <div class="mt-2 space-y-1">
                        <p><span class="font-medium">License:</span> {{ $v->license_plate }}</p>
                        <p><span class="font-medium">Capacity:</span> {{ $v->capacity }} passengers</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('vehicles.edit',$v) }}" class="text-teal-600 hover:text-teal-800">Edit</a>
                    <form method="POST" action="{{ route('vehicles.destroy',$v) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this vehicle?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <p class="text-gray-500 mb-4">You haven't added any vehicles yet.</p>
            <a href="{{ route('vehicles.create') }}" class="bg-teal text-white py-2 px-4 rounded-md hover:bg-teal-600 transition-colors">
                Add Your First Vehicle
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
