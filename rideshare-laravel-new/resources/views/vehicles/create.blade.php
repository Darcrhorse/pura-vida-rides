<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Add New Vehicle
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 text-red-700 rounded">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (session('ok'))
            <div class="mb-4 p-4 bg-green-50 text-green-700 rounded">
              {{ session('ok') }}
            </div>
          @endif

          <form method="POST" action="{{ route('vehicles.store') }}">
            @csrf
            @include('vehicles._form', ['vehicle' => new App\Models\Vehicle()])
            
            <div class="flex justify-end mt-6">
              <x-primary-button type="submit">
                Save Vehicle
              </x-primary-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
