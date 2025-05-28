<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Enroll Existing Student in New Subject') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow-sm">
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('enrollments.store') }}" method="POST">
                    @csrf

                    <!-- Student Dropdown -->
                    <div class="mb-4">
                        <label for="student_id" class="block text-sm font-medium text-gray-700">Select Student</label>
                        <select name="student_id" id="student_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Choose a student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" data-level="{{ $student->level }}">
                                        {{ $student->name }} (IC: {{ $student->ic }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject Dropdown -->
                    <div class="mb-4">
                        <label for="subject_id" class="block text-sm font-medium text-gray-700">Select Subject</label>
                        <select name="subject_id" id="subject_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Choose a subject --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" data-level="{{ $subject->level }}">
                                    {{ $subject->name }} | Level: {{ $subject->level }} | Class: {{ $subject->subject_class }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('student_lists.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md">Back</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Enroll</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const studentSelect = document.getElementById('student_id');
        const subjectSelect = document.getElementById('subject_id');
        const allSubjectOptions = Array.from(subjectSelect.options);

        studentSelect.addEventListener('change', () => {
            const selectedLevel = studentSelect.options[studentSelect.selectedIndex].dataset.level;

            // Clear current subject options
            subjectSelect.innerHTML = '<option value="">-- Choose a subject --</option>';

            // Filter and re-add matching options
            allSubjectOptions.forEach(option => {
                if (option.value === "") return; // skip placeholder
                if (option.dataset.level === selectedLevel) {
                    subjectSelect.appendChild(option.cloneNode(true));
                }
            });
        });
    </script>
</x-app-layout>
