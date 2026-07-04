<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <label class="block text-sm font-bold text-cyan-300 mb-2">
            Nombre de la sede o taller
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name', $workshop->name ?? '') }}"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500 outline-none">

        @error('name')
            <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-bold text-cyan-300 mb-2">
            Teléfono
        </label>

        <input
            type="text"
            name="phone"
            value="{{ old('phone', $workshop->phone ?? '') }}"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500 outline-none">

        @error('phone')
            <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-bold text-cyan-300 mb-2">
            Dirección
        </label>

        <input
            type="text"
            name="address"
            value="{{ old('address', $workshop->address ?? '') }}"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500 outline-none">

        @error('address')
            <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-bold text-cyan-300 mb-2">
            Horario de atención
        </label>

        <input
            type="text"
            name="opening_hours"
            value="{{ old('opening_hours', $workshop->opening_hours ?? '') }}"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500 outline-none">

        @error('opening_hours')
            <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-bold text-cyan-300 mb-2">
            Estado
        </label>

        <select
            name="status"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500 outline-none">

            <option value="activo" @selected(old('status', $workshop->status ?? 'activo') == 'activo')>
                Activa
            </option>

            <option value="inactivo" @selected(old('status', $workshop->status ?? '') == 'inactivo')>
                Inactiva
            </option>

        </select>

        @error('status')
            <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

</div>