<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            Login History
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <table class="table-auto w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">Role</th>
                            <th class="px-4 py-2">Action</th>
                            <th class="px-4 py-2">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logins as $login)
                            <tr>
                                <td class="px-4 py-2">{{ $login->user->name }}</td>
                                <td class="px-4 py-2">{{ $login->user->role }}</td>
                                <td class="px-4 py-2">{{ ucfirst($login->action) }}</td>
                                <td class="px-4 py-2">{{ $login->logged_in_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $logins->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
