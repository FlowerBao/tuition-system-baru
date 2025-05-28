<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Children\'s Learning Materials') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Learning Materials</h1>

        @if($materials->count() > 0)
            <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-200">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Title</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Description</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Subject</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Date</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materials as $material)
                            <tr class="border-t border-gray-200">
                                <td class="py-3 px-6 text-sm text-gray-700">{{ $material->title }}</td>
                                <td class="py-3 px-6 text-sm text-gray-700">{{ $material->description }}</td>
                                <td class="py-3 px-6 text-sm text-gray-700">{{ $material->subject->name }}</td>
                                <td class="py-3 px-6 text-sm text-gray-700">{{ \Carbon\Carbon::parse($material->date)->format('Y-m-d') }}</td>
                                <td class="py-3 px-6 text-sm text-blue-600 hover:text-blue-800">
                                    <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank">Download</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-gray-600 mt-6">No learning materials found for your registered children.</p>
        @endif
    </div>
</x-app-layout>
