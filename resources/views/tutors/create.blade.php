<x-app-layout>
    <x-slot name="header">  
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Register Tutor') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Register New Tutor</h2>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('tutors.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="tutor_name" class="block text-sm font-medium text-gray-700">Tutor Name</label>
                        <input type="text" name="tutor_name" id="tutor_name" value="{{ old('tutor_name') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <div>
                        <label for="tutor_ic" class="block text-sm font-medium text-gray-700">Tutor IC</label>
                        <input type="text" name="tutor_ic" id="tutor_ic" value="{{ old('tutor_ic') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <div>
                        <label for="tutor_email" class="block text-sm font-medium text-gray-700">Tutor Email</label>
                        <input type="email" name="tutor_email" id="tutor_email" value="{{ old('tutor_email') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <div>
                        <label for="tutor_phone" class="block text-sm font-medium text-gray-700">Tutor Phone Number</label>
                        <input type="text" name="tutor_phone" id="tutor_phone" value="{{ old('tutor_phone') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <div>
                        <label for="tutor_address" class="block text-sm font-medium text-gray-700">Tutor Address</label>
                        <textarea name="tutor_address" id="tutor_address" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>{{ old('tutor_address') }}</textarea>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" value="{{ old('password') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <label for="subject_id" class="block text-sm font-medium text-gray-700">Subject</label>
<select name="subject_id" id="subject_id" required
    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
    @foreach($subjects as $subject)
        <option value="{{ $subject->id }}"
            {{ in_array($subject->id, $assignedSubjectIds) ? 'disabled class=bg-gray-100 text-gray-400' : '' }}
            {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
            {{ $subject->name }} | Level: {{ $subject->level }} | Class: {{ $subject->subject_class }}
            {{ in_array($subject->id, $assignedSubjectIds) ? ' - (Assigned)' : '' }}
        </option>
    @endforeach
</select>


                   
                    <div class="flex justify-between">
                             <!-- Back Button -->
                             <a href="{{ route('tutors.index') }}" class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Back to Tutor List
                            </a>
                        
                       <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">Register </button>
                </div>
                      
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
