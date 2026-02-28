<x-app-layout>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-6">
        <div class="bg-white w-full max-w-2xl p-10 rounded-xl shadow-lg">

            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold">
                    Ajouter une catégorie
                </h1>

                <a href="{{ route('colocation.index') }}"
                    class="px-5 py-2.5 rounded-lg bg-gray-200 hover:bg-gray-300 text-sm font-semibold">
                    Retour
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-3 rounded-lg bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('categories.store', $colocation) }}">
                @csrf

                <div class="mb-6">
                    <label class="block mb-2 text-lg font-semibold text-gray-700">
                        Nom de la catégorie
                    </label>

                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-xl px-5 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400"
                        placeholder="Ex: Courses, Loyer, Internet...">

                    @error('name')
                        <p class="text-red-600 mt-2 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 text-base rounded-lg hover:bg-blue-700">
                        Ajouter
                    </button>
                </div>
            </form>
            <div class="mt-10">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">
                        Catégories
                    </h2>

                    <span class="text-sm text-gray-500">
                        {{ $categories->count() }} total
                    </span>
                </div>
                @if ($categories->count())
                    <div class="space-y-3">
                        @foreach ($categories as $cat)
                            <div class="flex items-center justify-between border border-gray-200 rounded-xl px-4 py-3">
                                <span class="font-semibold text-gray-800">
                                    {{ $cat->name }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 rounded-xl bg-gray-50 text-gray-600">
                        Aucune catégorie pour le moment.
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
