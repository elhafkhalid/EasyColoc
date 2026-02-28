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

                    <a href="{{ route('depenses.create', $colocation) }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        + Nouvelle dépense
                    </a>
                </div>

                @if ($colocation->depenses->isEmpty())
                    <p class="text-gray-500">Aucune dépense pour le moment.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="border-b text-gray-500">
                                <tr>
                                    <th class="text-left py-2">Titre</th>
                                    <th class="text-left py-2">Catégorie</th>
                                    <th class="text-left py-2">Payeur</th>
                                    <th class="text-left py-2">Montant</th>
                                    <th class="text-left py-2">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($colocation->depenses as $d)
                                    <tr class="border-b last:border-b-0">
                                        <td class="py-2">{{ $d->titre }}</td>
                                        <td class="py-2">{{ $d->category->name ?? '—' }}</td>
                                        <td class="py-2">{{ $d->payeur->name ?? '—' }}</td>
                                        <td class="py-2 font-semibold">{{ number_format($d->amount, 2) }} €</td>
                                        <td class="py-2">{{ \Carbon\Carbon::parse($d->date)->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
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

                    @if ($colocation && $colocation->status === 'active' && auth()->id() === $colocation->owner_id)
                        <button type="button" onclick="document.getElementById('inviteModal').showModal()"
                            class="mt-4 w-full px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">
                            + Inviter un membre
                        </button>

                        <dialog id="inviteModal" class="rounded-lg p-0 w-full max-w-md">
                            <div class="p-6">
                                <h2 class="text-lg font-semibold mb-4">
                                    Inviter un membre
                                </h2>

                                <form method="POST" action="{{ route('invitations.store', $colocation) }}">
                                    @csrf

                                    <div class="mb-4">
                                        <label class="block mb-1 font-semibold">Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="w-full border rounded px-3 py-2" placeholder="exemple@email.com"
                                            required>

                                        @error('email')
                                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="document.getElementById('inviteModal').close()"
                                            class="px-4 py-2 rounded bg-gray-200">
                                            Annuler
                                        </button>

                                        <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white">
                                            Inviter
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- click outside closes -->
                            <form method="dialog" class="p-0 m-0">
                                <button class="fixed inset-0 w-full h-full cursor-default" aria-label="close"></button>
                            </form>
                        </dialog>
                        @if ($errors->has('email'))
                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    document.getElementById('inviteModal').showModal();
                                });
                            </script>
                        @endif
                    @endif
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
