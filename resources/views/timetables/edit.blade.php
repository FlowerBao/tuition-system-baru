<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Update Timetable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('timetables.update', $timetable->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Subject (Read-only) -->
                        <div>
                            <label for="subject_name" class="block text-sm font-medium text-gray-700">Subject</label>
                            <input type="text" name="subject_name" value="{{ $timetable->subject->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" disabled>
                        </div>

                        <!-- Price (Editable) -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                            <input type="number" name="price" value="{{ $timetable->subject->price }}" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                        </div>

                        <!-- Level (Dropdown) -->
                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700">Level</label>
                            <select id="level" name="level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                                <option value="">-- Select Level --</option>
                                <option value="sekolah rendah" {{ old('level', $level) == 'sekolah rendah' ? 'selected' : '' }}>Sekolah Rendah</option>
                                <option value="sekolah menengah" {{ old('level', $level) == 'sekolah menengah' ? 'selected' : '' }}>Sekolah Menengah</option>
                                <option value="sekolah agama" {{ old('level', $level) == 'sekolah agama' ? 'selected' : '' }}>Sekolah Agama</option>
                            </select>
                        </div>

                        <!-- Subject Class (Dependent Dropdown) -->
                        <div>
                            <label for="subject_class" class="block text-sm font-medium text-gray-700">Subject Class</label>
                            <select id="subject_class" name="subject_class" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                                <!-- JS will populate this based on level -->
                            </select>
                        </div>

                        <!-- Day -->
                        <div>
                            <label for="day" class="block text-sm font-medium text-gray-700">Day</label>
                            <input type="text" name="day" value="{{ $timetable->day }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                        </div>

                        <!-- Start Time -->
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                            <input type="time" name="start_time" value="{{ $timetable->start_time }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                        </div>

                        <!-- End Time -->
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                            <input type="time" name="end_time" value="{{ $timetable->end_time }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                        </div>

                        <!-- Classroom Name -->
                        <div>
                            <label for="classroom_name" class="block text-sm font-medium text-gray-700">Classroom Name</label>
                            <input type="text" name="classroom_name" value="{{ $timetable->classroom_name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-between">
                             <!-- Back Button -->
                             <a href="{{ route('timetables.index') }}" class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Back to Timetable List
                            </a>

                            <!-- submit button -->
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Update Timetable
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const levelSelect = document.getElementById('level');
            const classSelect = document.getElementById('subject_class');

            const existingLevel = "{{ old('level', $level) }}";
            const existingClass = "{{ old('subject_class', $subjectClass) }}";

            const classOptions = {
                'sekolah rendah': [1, 2, 3, 4, 5, 6],
                'sekolah menengah': [1, 2, 3, 4, 5],
                'sekolah agama': [1, 2, 3, 4, 5, 6],
            };

            function updateClassOptions(level) {
                classSelect.innerHTML = '<option value="">-- Select Class --</option>';
                if (classOptions[level]) {
                    classOptions[level].forEach(function (num) {
                        const option = document.createElement('option');
                        option.value = num;
                        option.text = num;
                        if (existingLevel === level && existingClass == num) {
                            option.selected = true;
                        }
                        classSelect.appendChild(option);
                    });
                }
            }

            // Initial load
            if (existingLevel) {
                updateClassOptions(existingLevel);
            }

            levelSelect.addEventListener('change', function () {
                updateClassOptions(this.value);
            });
        });
    </script>
</x-app-layout>
