@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <label class="block text-cyan-300 font-semibold mb-2">
            Nombre de la forma de pago
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name', $paymentMethod->name ?? '') }}"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500 outline-none">

        @error('name')
            <p class="text-red-400 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-cyan-300 font-semibold mb-2">
            Estado
        </label>

        <select
            name="status"
            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

            <option value="activo"
                @selected(old('status', $paymentMethod->status ?? 'activo') === 'activo')>
                Activo
            </option>

            <option value="inactivo"
                @selected(old('status', $paymentMethod->status ?? '') === 'inactivo')>
                Inactivo
            </option>

        </select>

        @error('status')
            <p class="text-red-400 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="flex justify-end gap-4 mt-8">

    <a href="{{ route('admin.payment-methods.index') }}"
       class="px-6 py-3 rounded-2xl bg-slate-700 text-white font-semibold hover:bg-slate-600 transition">
        Cancelar
    </a>

    <button
        type="submit"
        class="px-8 py-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold shadow-lg hover:scale-105 transition">
        Guardar forma de pago
    </button>

</div>