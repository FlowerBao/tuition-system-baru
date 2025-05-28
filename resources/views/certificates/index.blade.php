<x-app-layout>
    <x-slot name="header">  
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Certificate List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Certificate List</h2>
                    <a href="{{ route('certificates.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Register New Certificate
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto mt-10">
                    <table class="min-w-full bg-white border border-gray-300 text-sm">
                        <thead class="bg-indigo-100 text-indigo-900 font-semibold">
                            <tr>
                                <th class="border px-4 py-2 text-left">Tutor Name</th>
                                <th class="border px-4 py-2 text-left">Link Certificate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($certificateList as $certificate)
                                <tr class="hover:bg-indigo-50">
                                    <td class="border px-4 py-2">
                                        {{ $certificate->tutor->name ?? 'Unknown' }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        <a href="https://ipfs.io/ipfs/{{ $certificate->ipfsHash }}" target="_blank" class="text-blue-600 underline">
                                            View Certificate
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center py-4 text-gray-500">
                                        No certificates found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
