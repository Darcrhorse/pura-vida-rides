<div class="space-y-6">
  <div class="space-y-4">
    <h3 class="text-lg font-medium">Vehicle Details</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <x-input-label for="make" :value="__('Make')" />
        <x-text-input id="make" name="make" type="text" class="mt-1 block w-full" 
          value="{{ old('make', $vehicle->make ?? '') }}" required autofocus />
        <x-input-error :messages="$errors->get('make')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="model" :value="__('Model')" />
        <x-text-input id="model" name="model" type="text" class="mt-1 block w-full" 
          value="{{ old('model', $vehicle->model ?? '') }}" required />
        <x-input-error :messages="$errors->get('model')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="year" :value="__('Year')" />
        <x-text-input id="year" name="year" type="number" min="1900" max="{{ date('Y') + 1 }}"
          class="mt-1 block w-full" value="{{ old('year', $vehicle->year ?? '') }}" required />
        <x-input-error :messages="$errors->get('year')" class="mt-2" />
        <p class="mt-1 text-sm text-gray-500">Vehicle model year</p>
      </div>
    </div>
  </div>

  <div class="space-y-4">
    <h3 class="text-lg font-medium">Registration Details</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <x-input-label for="license_plate" :value="__('License Plate')" />
        <x-text-input id="license_plate" name="license_plate" type="text" 
          class="mt-1 block w-full" value="{{ old('license_plate', $vehicle->license_plate ?? '') }}" required />
        <x-input-error :messages="$errors->get('license_plate')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="color" :value="__('Color')" />
        <x-text-input id="color" name="color" type="text" 
          class="mt-1 block w-full" value="{{ old('color', $vehicle->color ?? '') }}" required />
        <x-input-error :messages="$errors->get('color')" class="mt-2" />
      </div>
    </div>
  </div>

  <div class="space-y-4">
    <div>
      <x-input-label for="capacity" :value="__('Passenger Capacity')" />
      <x-text-input id="capacity" name="capacity" type="number" min="1" max="10"
        class="mt-1 block w-full" value="{{ old('capacity', $vehicle->capacity ?? 4) }}" required />
      <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
      <p class="mt-1 text-sm text-gray-500">How many passengers can you take?</p>
    </div>

    <div>
      <x-input-label for="features" :value="__('Features')" />
      <x-textarea id="features" name="features" class="mt-1 block w-full"
        placeholder="AC, USB ports, etc.">{{ old('features', $vehicle->features ?? '') }}</x-textarea>
      <x-input-error :messages="$errors->get('features')" class="mt-2" />
    </div>
  </div>
</div>
