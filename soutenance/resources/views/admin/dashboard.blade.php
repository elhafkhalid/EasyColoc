<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">EasyColoc</h2>

                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-200">
                        Dashboard
                    </a>

                    <a href="{{ route('colocation.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200">
                        Colocations
                    </a>

                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded bg-blue-600 text-white">
                        Admin
                    </a>

                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 rounded hover:bg-gray-200">
                        Profile
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Content -->
        <main class="flex-1 p-8">

            <h1 class="text-xl font-bold mb-6">
                Admin Dashboard
            </h1>

            <!-- Stats -->
            <div class="grid grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-500">Users</p>
                    <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                </div>

                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-500">Colocations actives</p>
                    <p class="text-2xl font-bold">{{ $Colocations }}</p>
                </div>

                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-500">Dépenses</p>
                    <p class="text-2xl font-bold">{{ $totalDepenses }} €</p>
                </div>

                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-500">Bannis</p>
                    <p class="text-2xl font-bold">{{ $bannedUsers }}</p>
                </div>
            </div>

            <!-- Users -->
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-lg font-semibold mb-4">
                    Gestion des utilisateurs
                </h2>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Nom</th>
                            <th class="text-left py-2">Email</th>
                            <th class="text-left py-2">Statut</th>
                            <th class="text-left py-2">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b">
                                <td class="py-2">{{ $user->name }}</td>
                                <td class="py-2">{{ $user->email }}</td>
                                <td class="py-2">
                                    {{ $user->is_banned ? 'Banni' : 'Actif' }}
                                </td>
                                <td class="py-2">
                                    @if ($user->role_id != 1)
                                        <form method="POST"
                                              action="{{ $user->is_banned
                                                  ? route('admin.users.unban', $user)
                                                  : route('admin.users.ban', $user) }}">
                                            @csrf
                                            <button class="text-sm {{ $user->is_banned ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $user->is_banned ? 'Débannir' : 'Bannir' }}
                                            </button>
                                        </form>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</x-app-layout>