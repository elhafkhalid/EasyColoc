<x-app-layout>
    <div class="p-8 bg-gray-100  flex justify-center">
        <div class="bg-white p-6 rounded shadow w-full max-w-xl">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-xl font-bold">
                    Nouvelle dépense
                </h1>

                <a href="{{ route('colocation.show', $colocation) }}"
                    class="text-sm px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">
                    Retour
                </a>
            </div>

            <form method="POST" action="{{ route('depenses.store', $colocation) }}">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Titre</label>
                    <input type="text" name="titre" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Montant (€)</label>
                    <input type="number" step="0.01" name="amount" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Date</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}"
                        class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Catégorie</label>
                    <select name="category_id" class="w-full border rounded px-3 py-2">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block mb-1 font-semibold">Payeur</label>
                    <select name="payeur_id" class="w-full border rounded px-3 py-2">
                        @foreach ($members as $m)
                            <option value="{{ $m->id }}">
                                {{ $m->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Ajouter
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
