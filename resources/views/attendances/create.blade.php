<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 bg-blue-200 px-4 py-2 rounded">
            {{ __('Take Attendance') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('attendances.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="date" required class="mt-1 w-full border rounded px-3 py-2" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Subject</label>
                        <select name="subject_id" class="w-full px-3 py-2 border rounded" required>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->level }} {{ $subject->class }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Students</label>
                        <div class="border p-3 rounded max-h-60 overflow-y-auto">
                            @foreach($students as $student)
                                <label class="block mb-2">
                                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="mr-2">
                                    {{ $student->name }} (IC: {{ $student->ic }})
                                </label>
                            @endforeach
                        </div>
                    </div>

                     <div class="flex justify-between">
                     <!-- Back Button -->
                            <a href="{{ route('attendances.index') }}" class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Back to Attendance List
                            </a>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Submit Attendance
                    </button>
</div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
