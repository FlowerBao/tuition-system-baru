<x-app-layout>
    <x-slot name="header">  
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Learning Materials') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Header Title & Upload Button --}}
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">
                        @if ($isParent)
                            Your Children’s Learning Materials
                        @elseif ($isTutor)
                            Learning Materials for Your Subjects
                        @else
                            All Learning Materials
                        @endif
                    </h2>

                    {{-- Only Admin and Tutor can upload --}}
                    @if(!$isParent)
                        <a href="{{ route('materials.create') }}" class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-700">
                            Upload Learning Material
                        </a>
                    @endif
                </div>

                {{-- Filter for Parents --}}
                @if ($isParent)
                    <form method="GET" action="{{ route('materials.index') }}" class="mb-6 space-y-4">
                        <div>
                            <label for="student_id" class="block font-semibold mb-1">Select Student:</label>
                            <select name="student_id" id="student_id" class="w-full border rounded p-2" onchange="this.form.submit()">
                                <option value="">-- All Students --</option>
                                @forelse($students as $student)
                                    <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}
                                    </option>
                                @empty
                                    <option value="" disabled>No students found for this parent.</option>
                                @endforelse
                            </select>
                        </div>

                        @if($subjects->count())
                            <div>
                                <label for="subject_id" class="block font-semibold mb-1">Select Subject:</label>
                                <select name="subject_id" id="subject_id" class="w-full border rounded p-2" onchange="this.form.submit()">
                                    <option value="">-- All Subjects --</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </form>
                @endif

                {{-- Materials Table --}}
                <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-200">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Title</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Description</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Subject</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Date</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">File</th>
                                @if(!$isParent)
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($materials as $material)
                                <tr class="border-t border-gray-200">
                                    <td class="py-3 px-6 text-sm text-gray-700">{{ $material->title }}</td>
                                    <td class="py-3 px-6 text-sm text-gray-700">{{ $material->description }}</td>
                                    <td class="py-3 px-6 text-sm text-gray-700">{{ $material->subject->name }}</td>
                                    <td class="py-3 px-6 text-sm text-gray-700">{{ $material->date }}</td>
                                    <td class="py-3 px-6 text-sm text-gray-700">
                                        <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="text-blue-500 hover:text-blue-700" title="Download">
                                            {{-- Download Icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M12 2l.117 .007a1 1 0 0 1 .876 .876l.007 .117v4l.005 .15a2 2 0 0 0 1.838 1.844l.157 .006h4l.117 .007a1 1 0 0 1 .876 .876l.007 .117v9a3 3 0 0 1 -2.824 2.995l-.176 .005h-10a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-14a3 3 0 0 1 2.824 -2.995l.176 -.005zm0 8a1 1 0 0 0 -1 1v3.585l-.793 -.792a1 1 0 0 0 -1.32 -.083l-.094 .083a1 1 0 0 0 0 1.414l2.5 2.5l.044 .042l.068 .055l.11 .071l.114 .054l.105 .035l.15 .03l.116 .006l.117 -.007l.117 -.02l.108 -.033l.081 -.034l.098 -.052l.092 -.064l.094 -.083l2.5 -2.5a1 1 0 0 0 0 -1.414l-.094 -.083a1 1 0 0 0 -1.32 .083l-.793 .791v-3.584a1 1 0 0 0 -.883 -.993zm2.999 -7.001l4.001 4.001h-4z" />
                                            </svg>
                                        </a>
                                    </td>

                                    {{-- Actions (Edit/Delete) for Admin & Tutor --}}
                                    @if (!$isParent)
                                        <td class="py-3 px-6 text-sm text-gray-700">
                                            <form action="{{ route('materials.destroy', $material->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this material?')">
                                                    {{-- Trash Icon --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z" />
                                                        <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $isParent ? 5 : 6 }}" class="text-center py-6 text-gray-500">
                                        No learning materials found.
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
