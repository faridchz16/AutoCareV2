@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Placa --}}
    <div>
        <label class="block text-cyan-300 font-semibold mb-2">
            Placa
        </label>

        <input
            type="text"
            name="plate"
            value="{{ old('plate', $vehicle->plate ?? '') }}"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 uppercase focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

        @error('plate')
            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tipo de vehículo --}}
    <div>
        <label class="block text-cyan-300 font-semibold mb-2">
            Tipo de vehículo
        </label>

        <select
            name="vehicle_type_id"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

            <option value="">
                Seleccione un tipo de vehículo
            </option>

            @foreach($vehicleTypes as $type)
                <option value="{{ $type->id }}"
                    @selected(old('vehicle_type_id', $vehicle->vehicle_type_id ?? '') == $type->id)>
                    {{ $type->name }}
                </option>
            @endforeach

        </select>

        @error('vehicle_type_id')
            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    {{-- Marca --}}
    <div>
        <label class="block text-cyan-300 font-semibold mb-2">
            Marca
        </label>

        <input
            type="text"
            name="brand"
            value="{{ old('brand', $vehicle->brand ?? '') }}"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

        @error('brand')
            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    {{-- Modelo --}}
    <div>
        <label class="block text-cyan-300 font-semibold mb-2">
            Modelo
        </label>

        <input
            type="text"
            name="model"
            value="{{ old('model', $vehicle->model ?? '') }}"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

        @error('model')
            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    {{-- Año --}}
    <div>
        <label class="block text-cyan-300 font-semibold mb-2">
            Año
        </label>

        <input
            type="number"
            name="year"
            value="{{ old('year', $vehicle->year ?? '') }}"
            min="1980"
            max="{{ date('Y') + 1 }}"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

        @error('year')
            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    {{-- Color --}}
    <div>
        <label class="block text-cyan-300 font-semibold mb-2">
            Color
        </label>

        <input
            type="text"
            name="color"
            value="{{ old('color', $vehicle->color ?? '') }}"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

        @error('color')
            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    {{-- Kilometraje --}}
    <div class="md:col-span-2">
        <label class="block text-cyan-300 font-semibold mb-2">
            Kilometraje actual
        </label>

        <input
            type="number"
            name="current_mileage"
            value="{{ old('current_mileage', $vehicle->current_mileage ?? '') }}"
            min="0"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

        @error('current_mileage')
            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="flex flex-col sm:flex-row justify-center gap-4 pt-8">

    <button
        type="submit"
        class="inline-flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-4 font-bold text-white hover:scale-105 transition shadow-lg shadow-blue-900/30">

        <x-client.icon-vehicle class="w-5 h-5" />

        Guardar vehículo

    </button>

    <a
        href="{{ route('client.vehicles.index') }}"
        class="inline-flex items-center justify-center rounded-2xl bg-slate-700 px-8 py-4 font-semibold text-white hover:bg-slate-600 transition">

        Cancelar

    </a>

</div>