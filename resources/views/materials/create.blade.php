<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Upload Learning Material') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Upload New Learning Material</h1>

        <!-- Display any validation errors -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form to Upload Learning Material -->
        <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required></textarea>
                </div>

                <!-- Subject (Read-Only) -->
                <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700">Subject</label>
                    <div class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-700">
                        {{ $subjects->first()->name }} <!-- Assuming you want to show the first subject as the selected one -->
                    </div>
                    <input type="hidden" name="subject_id" value="{{ $subjects->first()->id }}">
                </div>

                <!-- Tutor (Automatically set to logged-in user's tutor) -->
                <input type="hidden" name="tutor_id" value="{{ auth()->user()->id }}">

                <!-- File Upload -->
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700">Learning Material File</label>
                    <input type="file" name="file" id="file" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-between">
                     <!-- Back Button -->
                            <a href="{{ route('materials.index') }}" class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Back to Material List
                            </a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Upload Material
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
