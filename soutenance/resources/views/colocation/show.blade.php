<x-app-layout>
    <div class="p-8 bg-gray-100 min-h-screen">

        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold uppercase">
                {{ $colocation->name }}
            </h1>

            <div class="flex gap-3">
                <a href="{{ route('colocation.index') }}" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
                    Retour
                </a>

                <form method="POST" action="{{ route('colocation.cancel', $colocation) }}">
                    @csrf

                    <button type="submit" class="px-4 py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200">
                        Annuler la colocation
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left (Dépenses récentes) -->
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Dépenses récentes</h2>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        + Nouvelle dépense
                    </button>
                </div>

                <p class="text-gray-500">Aucune dépense pour le moment.</p>
            </div>

            <!-- Right column -->
            <div class="space-y-6">

                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-2">Qui doit à qui ?</h2>
                    <p class="text-gray-500">Aucun remboursement en attente.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Membres de la coloc</h2>
                        <span class="text-sm text-gray-500">ACTIFS</span>
                    </div>

                    <div class="space-y-3">
                        @foreach ($colocation->users as $user)
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ strtoupper($user->pivot->role) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button class="mt-4 w-full px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">
                        + Inviter un membre
                    </button>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
