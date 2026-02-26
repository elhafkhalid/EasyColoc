<x-app-layout>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
        <div class="bg-white w-full max-w-2xl p-10 rounded-2xl shadow-lg">

            <h1 class="text-3xl font-bold mb-8 text-center">
                Créer une colocation
            </h1>

            <form method="POST" action="{{ route('colocation.store') }}">
                @csrf

                <div class="mb-6">
                    <label class="block mb-2 text-lg font-semibold text-gray-700">
                        Nom de la colocation
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-xl px-5 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400"
                        placeholder="Ex: Coloc Maarif"
                    >

                    @error('name')
                        <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between items-center mt-10">
                    <a href="{{ route('colocation.index') }}"
                       class="px-6 py-3 text-lg rounded-lg bg-gray-200 hover:bg-gray-300">
                        Annuler
                    </a>

                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-3 text-lg rounded-lg hover:bg-blue-700">
                        Créer la colocation
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>