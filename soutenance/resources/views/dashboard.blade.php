<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">EasyColoc</h2>

                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded bg-blue-600 text-white">
                        Dashboard
                    </a>

                    <a href="{{ route('colocation.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200">
                        Colocations
                    </a>

                    @if (auth()->user()->role_id == 1)
                        <a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">
                            Admin
                        </a>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 rounded hover:bg-gray-200">
                        Profile
                    </a>
                </nav>
            </div>

            <div class="mt-auto p-6">
                <div class="bg-gray-900 text-white rounded-xl p-4 shadow">
                    <p class="text-xs opacity-80 mb-1">VOTRE RÉPUTATION</p>
                    <p class="text-lg font-bold">+{{ auth()->user()->reputation_score ?? 0 }} points</p>
                    <div class="mt-3 h-2 rounded bg-gray-700">
                        <div class="h-2 rounded bg-blue-500 w-1/3"></div>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-6">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-800">
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Content -->
        <main class="flex-1 p-8">

            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-xl font-bold uppercase tracking-wide text-gray-700">
                    Tableau de bord
                </h1>

                <a href="{{ route('colocation.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 shadow">
                    + Nouvelle colocation
                </a>
            </div>

            <!-- Top cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-2xl shadow p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Mon score réputation</p>
                        <p class="text-4xl font-bold text-gray-800">
                            {{ auth()->user()->reputation_score ?? 0 }}
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-xl">
                        ⭐
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Dépenses Globales (Feb)</p>
                        <p class="text-4xl font-bold text-gray-800">
                            {{ number_format($totalDepenses ?? 0, 2) }} €
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-xl">
                        🛒
                    </div>
                </div>
            </div>

            <!-- Bottom area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Dépenses récentes -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Dépenses récentes</h2>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700">
                            Voir tout
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-gray-500 border-b">
                                <tr>
                                    <th class="text-left py-3">TITRE / CATÉGORIE</th>
                                    <th class="text-left py-3">PAYEUR</th>
                                    <th class="text-left py-3">MONTANT</th>
                                    <th class="text-left py-3">COLOC</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($recentDepenses as $depense)
                                    <tr class="border-b last:border-b-0">
                                        <td class="py-3 text-gray-800">
                                            {{ $depense->titre }}
                                        </td>
                                        <td class="py-3 text-gray-600">
                                            {{ $depense->payeur->name ?? '-' }}
                                        </td>
                                        <td class="py-3 font-semibold text-gray-800">
                                            {{ number_format($depense->amount, 2) }} €
                                        </td>
                                        <td class="py-3 text-gray-600">
                                            {{ optional($depense->colocation)->name ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-10 text-center text-gray-500">
                                            Aucune dépense récente
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Membres de la coloc</h2>
                        <span class="text-sm text-gray-500">ACTIFS</span>
                    </div>

                    <div class="space-y-3">
                        @if ($colocation)
                            <div class="space-y-3">
                                @foreach ($colocation->users as $user)
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold">{{ $user->name }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ strtoupper($user->pivot->role) }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">
                                Aucune colocation active
                            </p>
                        @endif
                    </div>

                    <button class="mt-4 w-full px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">
                        + Inviter un membre
                    </button>
                </div>
            </div>

        </main>
    </div>
</x-app-layout>
