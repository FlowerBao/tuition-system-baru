<x-app-layout>
    <x-slot name="header">  
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Update Tutor') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Update Tutor</h1>

        <form action="{{ route('tutors.update', $tutor->id) }}" method="POST" class="space-y-6 bg-white p-6 shadow rounded-lg">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="tutor_name" class="block text-sm font-medium text-gray-700">Name</label>
                <input 
                    type="text" 
                    name="tutor_name" 
                    id="tutor_name" 
                    value="{{ old('tutor_name', $tutor->tutor_name) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                    required>
            </div>

            <!-- IC -->
            <div>
                <label for="tutor_ic" class="block text-sm font-medium text-gray-700">IC</label>
                <input 
                    type="text" 
                    name="tutor_ic" 
                    id="tutor_ic" 
                    value="{{ old('tutor_ic', $tutor->tutor_ic) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                    required>
            </div>

            <!-- Email -->
            <div>
                <label for="tutor_email" class="block text-sm font-medium text-gray-700">Email</label>
                <input 
                    type="email" 
                    name="tutor_email" 
                    id="tutor_email" 
                    value="{{ old('tutor_email', $tutor->tutor_email) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                    required>
            </div>

            <!-- Phone -->
            <div>
                <label for="tutor_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input 
                    type="text" 
                    name="tutor_phone" 
                    id="tutor_phone" 
                    value="{{ old('tutor_phone', $tutor->tutor_phone) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                    required>
            </div>

            <!-- Address -->
            <div>
                <label for="tutor_address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea 
                    name="tutor_address" 
                    id="tutor_address" 
                    rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('tutor_address', $tutor->tutor_address) }}</textarea>
            </div>

            <!-- Subject with Level and Subject Class -->
            <div>
                <label for="subject_id" class="block text-sm font-medium text-gray-700">Subject</label>
                <select 
                    name="subject_id" 
                    id="subject_id" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                    required>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id', $tutor->subject_id) == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }} - Level: {{ $subject->level }} - Class: {{ $subject->subject_class }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-between">
                             <!-- Back Button -->
                             <a href="{{ route('tutors.index') }}" class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Back to Tutor List
                            </a>
                <button 
                    type="submit" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                    Update Tutor
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
