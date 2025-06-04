<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Student Preview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-xl font-bold mb-4">List of Students</h2>
            <table class="min-w-full bg-white border border-gray-300 text-sm">
                <thead class="bg-indigo-100 text-indigo-900 font-semibold">
                    <tr>
                        <th class="border px-4 py-2 text-left">Name</th>
                        <th class="border px-4 py-2 text-left">IC Number</th>
                        <th class="border px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr class="hover:bg-indigo-50">
                            <td class="border px-4 py-2">{{ $student->name }}</td>
                            <td class="border px-4 py-2">{{ $student->ic }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('students.show', $student->id) }}"
                                   class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
