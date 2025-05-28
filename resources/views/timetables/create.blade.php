<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Register Subject and Timetable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('timetables.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Subject Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Subject Name</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <!-- Subject Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="price" id="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <!-- Subject Level -->
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700">Subject Level</label>
                        <select name="level" id="level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">-- Select Level --</option>
                            <option value="Sekolah Rendah">Sekolah Rendah</option>
                            <option value="Sekolah Menengah">Sekolah Menengah</option>
                            <option value="Sekolah Agama">Sekolah Agama</option>
                        </select>
                    </div>

                    <!-- Subject Class -->
                    <div id="class-selection" class="hidden">
                        <label for="subject_class" class="block text-sm font-medium text-gray-700">Class</label>
                        <select name="subject_class" id="subject_class" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <!-- Options dynamically inserted by JS -->
                        </select>
                    </div>

                    <!-- Timetable Fields -->
                    <div class="space-y-4">
                        <div>
                            <label for="day" class="block text-sm font-medium text-gray-700">Day</label>
                            <input type="text" name="day" id="day" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                            <input type="time" name="start_time" id="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                            <input type="time" name="end_time" id="end_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label for="classroom_name" class="block text-sm font-medium text-gray-700">Classroom Name</label>
                            <input type="text" name="classroom_name" id="classroom_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>

                        <!-- Select Tutors -->
                        <!-- <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700">Select Tutor</label>
                            <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">-- Select Tutor --</option>
                                @foreach($tutors as $tutor)
                                <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                                @endforeach
                            </select>
                        </div> -->

                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-between">
                             <!-- Back Button -->
                             <a href="{{ route('timetables.index') }}" class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Back to Timetable List
                            </a>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Register Subject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const levelSelect = document.getElementById('level');
        const classSelection = document.getElementById('class-selection');
        const subjectClass = document.getElementById('subject_class');

        levelSelect.addEventListener('change', function () {
            const level = this.value;
            subjectClass.innerHTML = '';
            classSelection.classList.add('hidden');

            if (level === 'Sekolah Rendah' || level === 'Sekolah Agama') {
                for (let i = 1; i <= 6; i++) {
                    subjectClass.innerHTML += `<option value="${i}">${i}</option>`;
                }
                classSelection.classList.remove('hidden');
            } else if (level === 'Sekolah Menengah') {
                for (let i = 1; i <= 5; i++) {
                    subjectClass.innerHTML += `<option value="${i}">${i}</option>`;
                }
                classSelection.classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
