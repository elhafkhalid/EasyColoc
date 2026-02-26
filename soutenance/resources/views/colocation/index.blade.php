<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
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
        <div class="p-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Mes colocations
                </h1>

                <a href="{{ route('colocation.create') }}"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 shadow">
                    + Nouvelle colocation
                </a>
            </div>

            @if ($colocations->isEmpty())
                <!-- Empty state -->
                <div class="bg-white rounded-2xl shadow p-10 flex flex-col items-center justify-center text-center">
                    <div class="text-gray-400 text-4xl mb-4">👥</div>

                    <h2 class="text-lg font-semibold mb-2 text-gray-800">
                        Aucune colocation
                    </h2>

                    <p class="text-gray-500 mb-4">
                        Commencez par créer une nouvelle colocation
                    </p>

                    <a href="{{ route('colocation.create') }}"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                        Créer une colocation
                    </a>
                </div>
            @else
                <!-- Colocations list -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($colocations as $colocation)
                        <div class="bg-white rounded-2xl shadow p-6 flex flex-col justify-between">

                            <div>
                                <h2 class="text-lg font-bold text-gray-800 mb-1">
                                    {{ $colocation->name }}
                                </h2>

                                <p class="text-sm text-gray-500 mb-4">
                                    Statut :
                                    <span
                                        class="font-semibold {{ $colocation->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ ucfirst($colocation->status) }}
                                    </span>
                                </p>

                                <p class="text-sm text-gray-500">
                                    Propriétaire :
                                    <span class="font-semibold text-gray-700">
                                        {{ $colocation->owner->name ?? '—' }}
                                    </span>
                                </p>
                            </div>

                            <div class="mt-6 flex justify-between items-center">
                                <span class="text-xs text-gray-400">
                                    {{ $colocation->users->count() }} membre(s)
                                </span>
                                
                                <a href="{{ route('colocation.show', $colocation) }}"
                                    class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                                    Voir →
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
