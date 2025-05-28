<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('All Registered Students') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto mt-10">
                <h2 class="text-2xl font-bold mb-4">All Students Registered</h2>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="min-w-full bg-white border border-gray-300 text-sm">
                    <thead class="bg-indigo-100 text-indigo-900 font-semibold">
                        <tr>
                            <th class="border px-4 py-2 text-left">Name</th>
                            <th class="border px-4 py-2 text-left">IC Number</th>
                            <th class="border px-4 py-2 text-left">Phone</th>
                            <th class="border px-4 py-2 text-left">Subject</th>
                            <th class="border px-4 py-2 text-left">Level</th>
                            <th class="border px-4 py-2 text-left">Subject Class</th>
                            <th class="border px-4 py-2 text-left">Fee Price (RM)</th>
                            <th class="border px-4 py-2 text-left">Registration Date</th>
                            <th class="border px-4 py-2 text-left">Reminder</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($studentLists as $student)
                            <tr class="hover:bg-indigo-50">
                                <td class="border px-4 py-2">{{ $student->name }}</td>
                                <td class="border px-4 py-2">{{ $student->ic }}</td>
                                <td class="border px-4 py-2">{{ $student->phone }}</td>
                                <td class="border px-4 py-2">
                                    {{ optional($student->subject)->name ?? 'N/A' }}
                                </td>
                                <td class="border px-4 py-2">{{ $student->level }}</td>
                                <td class="border px-4 py-2">
                                    {{ optional($student->subject)->subject_class ?? 'N/A' }}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ optional($student->subject)->price ? 'RM ' . number_format($student->subject->price, 2) : 'N/A' }}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $student->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="border px-4 py-2">
                                    <form action="" method="POST">
                                    @csrf
                                        <button type="submit" class="bg-red-300 hover:bg-red-500 text-black font-semibold py-1 px-3 rounded text-sm flex items-center gap-1">
            🔔 Reminder
        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $studentLists->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
