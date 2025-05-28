<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Register New User</h2>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('parents.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="parent_name" class="block text-sm font-medium text-gray-700">Parent Name</label>
                        <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <div>
                        <label for="parent_ic" class="block text-sm font-medium text-gray-700">Parent IC</label>
                        <input type="text" name="parent_ic" id="parent_ic" value="{{ old('parent_ic') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <div> 
                        <label for="parent_email" class="block text-sm font-medium text-gray-700">Parent Email</label>
                        <input type="email" name="parent_email" id="parent_email" value="{{ old('parent_email') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <div>
                        <label for="parent_phone" class="block text-sm font-medium text-gray-700">Parent Phone Number</label>
                        <input type="text" name="parent_phone" id="parent_phone" value="{{ old('parent_phone') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <div>
                        <label for="parent_address" class="block text-sm font-medium text-gray-700">Parent Address</label>
                        <textarea name="parent_address" id="parent_address" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>{{ old('parent_address') }}</textarea>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" value="{{ old('password') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                    </div>

                    <div class="flex justify-end">
                        
                       <button type="submit" class="btn btn-primary">Register </button>
                </div>
                      
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
