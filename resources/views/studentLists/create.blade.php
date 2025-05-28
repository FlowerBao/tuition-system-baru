<x-app-layout>
    <x-slot name="header">  
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Register Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Register New Student</h2>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('student_lists.store') }}" method="POST" id="studentForm">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Student Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <div>
                        <label for="ic" class="block text-sm font-medium text-gray-700">Student IC</label>
                        <input type="text" name="ic" id="ic" value="{{ old('ic') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <!-- Dropdown for Student Level -->
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700">Student Level</label>
                        <select name="level" id="level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="sekolah rendah" {{ old('level') == 'sekolah rendah' ? 'selected' : '' }}>Sekolah Rendah</option>
                            <option value="sekolah menengah" {{ old('level') == 'sekolah menengah' ? 'selected' : '' }}>Sekolah Menengah</option>
                            <option value="sekolah agama" {{ old('level') == 'sekolah agama' ? 'selected' : '' }}>Sekolah Agama</option>
                        </select>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Student Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <!-- Subject Dropdown -->
                    <label for="subject_id" class="block text-sm font-medium text-gray-700">Subject</label>
                    <select name="subject_id" id="subject_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <!-- Dynamically loaded subjects will appear here -->
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }} | Level: {{ $subject->level }} | Class: {{ $subject->subject_class }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Adding margin top to the button -->
                    <div class="mt-6 flex justify-between">
                     <!-- Back Button -->
                            <a href="{{ route('studentLists.index') }}" class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Back to Children List
                            </a>
                        <button type="submit" class="btn btn-primary">Register Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Listen for changes on the level dropdown
        document.getElementById('level').addEventListener('change', function() {
            let level = this.value;

            // Make an AJAX request to fetch subjects based on the selected level
            fetch(`/get-subjects/${level}`)
                .then(response => response.json())
                .then(data => {
                    let subjectSelect = document.getElementById('subject_id');
                    subjectSelect.innerHTML = ''; // Clear previous subjects
                    data.subjects.forEach(subject => {
                        let option = document.createElement('option');
                        option.value = subject.id;
                        option.textContent = `${subject.name} | Level: ${subject.level} | Class: ${subject.subject_class}`;
                        subjectSelect.appendChild(option);
                    });
                });
        });
    </script>
</x-app-layout>