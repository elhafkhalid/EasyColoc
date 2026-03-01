<x-app-layout>
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow p-6">

            <h1 class="text-xl font-bold mb-6">Mes invitations</h1>

            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->has('msg'))
                <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                    {{ $errors->first('msg') }}
                </div>
            @endif

            @if ($invitations->isEmpty())
                <p class="text-gray-500">Aucune invitation en attente.</p>
            @else
                <div class="space-y-4">
                    @foreach ($invitations as $inv)
                        <div class="border rounded-xl p-4 flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-gray-800">
                                    {{ $inv->colocation->name ?? 'Colocation' }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Invitée à : {{ $inv->email }}
                                </p>
                            </div>

                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('invitations.refuse', $inv) }}">
                                    @csrf
                                    <button class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">
                                        Refuser
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('invitations.accept', $inv) }}">
                                    @csrf
                                    <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                                        Accepter
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>