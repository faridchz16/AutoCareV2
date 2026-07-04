@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <label class="block text-cyan-300 font-semibold mb-2">
            Servicio
        </label>

        <select
            name="service_type_id"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

            <option value="">Seleccione un servicio</option>

            @foreach($services as $service)
                <option value="{{ $service->id }}"
                    @selected(old('service_type_id', $serviceDate->service_type_id ?? '') == $service->id)>
                    {{ $service->name }}
                </option>
            @endforeach

        </select>

        @error('service_type_id')
            <p class="text-red-400 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-cyan-300 font-semibold mb-2">
            Fecha de atención
        </label>

        <input
            type="date"
            name="available_date"
            value="{{ old('available_date', $serviceDate->available_date ?? '') }}"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

        @error('available_date')
            <p class="text-red-400 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-cyan-300 font-semibold mb-2">
            Hora de inicio
        </label>

        <input
            type="time"
            name="start_time"
            value="{{ old('start_time', isset($serviceDate) ? substr($serviceDate->start_time,0,5) : '') }}"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

        @error('start_time')
            <p class="text-red-400 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-cyan-300 font-semibold mb-2">
            Hora de fin
        </label>

        <input
            type="time"
            name="end_time"
            value="{{ old('end_time', isset($serviceDate) ? substr($serviceDate->end_time,0,5) : '') }}"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

        @error('end_time')
            <p class="text-red-400 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-cyan-300 font-semibold mb-2">
            Estado
        </label>

        <select
            name="status"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

            <option value="disponible" @selected(old('status',$serviceDate->status ?? 'disponible')=='disponible')>
                Disponible
            </option>

            <option value="reservado" @selected(old('status',$serviceDate->status ?? '')=='reservado')>
                Reservado
            </option>

            <option value="no_disponible" @selected(old('status',$serviceDate->status ?? '')=='no_disponible')>
                No disponible
            </option>

            <option value="cancelado" @selected(old('status',$serviceDate->status ?? '')=='cancelado')>
                Cancelado
            </option>

        </select>

        @error('status')
            <p class="text-red-400 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="flex justify-end gap-4 mt-8">

    <a href="{{ route('admin.service-dates.index') }}"
       class="px-6 py-3 rounded-2xl bg-slate-700 text-white font-semibold hover:bg-slate-600 transition">
        Cancelar
    </a>

    <button
        type="submit"
        class="px-8 py-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold shadow-lg hover:scale-105 transition">
        Guardar fecha
    </button>

</div>