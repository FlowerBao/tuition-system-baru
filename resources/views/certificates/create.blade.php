<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Certificate') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-medium mb-2">Please fix the following errors:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('certificates.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Certificates
            </a>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            {{-- Progress Steps --}}
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <div id="step1-indicator" class="w-8 h-8 rounded-full bg-white bg-opacity-30 flex items-center justify-center text-white font-semibold">1</div>
                            <span class="text-white font-medium">Connect Wallet</span>
                        </div>
                        <div class="h-0.5 w-8 bg-white bg-opacity-30"></div>
                        <div class="flex items-center space-x-2">
                            <div id="step2-indicator" class="w-8 h-8 rounded-full bg-white bg-opacity-30 flex items-center justify-center text-white font-semibold">2</div>
                            <span class="text-white font-medium">Upload Certificate</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-8">
                {{-- Connect Wallet Section --}}
                <div id="wallet-section" class="border-2 border-dashed border-gray-200 rounded-xl p-6 transition-all duration-300">
                    <div class="text-center">
                        <div class="mx-auto w-16 h-16 bg-gradient-to-br from-purple-500 to-blue-500 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Connect Your Wallet</h3>
                        <p class="text-gray-600 mb-6">Connect your MetaMask wallet to proceed with certificate upload</p>
                        
                        <button 
                            onclick="connectWallet()" 
                            id="connect-wallet-btn"
                            type="button" 
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-medium rounded-lg hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-purple-300 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                            </svg>
                            Connect MetaMask
                        </button>
                        
                        <div id="wallet-connected" class="hidden mt-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                            <div class="flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-emerald-700 font-medium">Wallet Connected</span>
                            </div>
                            <p id="wallet-address-display" class="text-sm text-emerald-600 mt-2 text-center font-mono"></p>
                        </div>
                    </div>
                </div>

                {{-- Upload Form Section --}}
                <div id="upload-section" class="opacity-50 pointer-events-none transition-all duration-300">
                    <form action="{{ route('certificates.upload-ipfs') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Hidden Wallet Address Field --}}
                        <input type="hidden" name="wallet_address" id="wallet_address">

                        {{-- Tutor Selection --}}
                        <div class="space-y-2">
                            <label for="tutor_id" class="block text-sm font-semibold text-gray-700">
                                Select Tutor <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select 
                                    name="tutor_id" 
                                    id="tutor_id" 
                                    required 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white">
                                    <option value="">Choose a tutor from the list</option>
                                    @foreach ($tutors as $tutor)
                                        <option value="{{ $tutor->id }}">{{ $tutor->user->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- File Upload --}}
                        <div class="space-y-2">
                            <label for="certificate" class="block text-sm font-semibold text-gray-700">
                                Upload Certificate <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div 
                                    id="drop-zone"
                                    class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 hover:bg-blue-50 transition-colors duration-200 cursor-pointer">
                                    <input 
                                        type="file" 
                                        name="certificate" 
                                        id="certificate" 
                                        required 
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="hidden">
                                    
                                    <div id="upload-placeholder">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-700 mb-2">Drop your certificate here</p>
                                        <p class="text-sm text-gray-500 mb-4">or click to browse files</p>
                                        <p class="text-xs text-gray-400">Supports PDF, JPG, PNG (Max 10MB)</p>
                                    </div>
                                    
                                    <div id="file-preview" class="hidden">
                                        <div class="flex items-center justify-center space-x-3">
                                            <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                            </svg>
                                            <div class="text-left">
                                                <p id="file-name" class="font-medium text-gray-700"></p>
                                                <p id="file-size" class="text-sm text-gray-500"></p>
                                            </div>
                                            <button type="button" onclick="clearFile()" class="text-red-500 hover:text-red-700">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-4">
                            <button 
                                type="submit" 
                                id="submit-btn"
                                class="w-full py-4 px-6 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    Upload Certificate to IPFS
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced JavaScript --}}
    <script>
        let isWalletConnected = false;

        // Wallet Connection
        async function connectWallet() {
            const connectBtn = document.getElementById('connect-wallet-btn');
            const originalText = connectBtn.innerHTML;
            
            // Show loading state
            connectBtn.innerHTML = `
                <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Connecting...
            `;
            connectBtn.disabled = true;

            if (typeof window.ethereum !== 'undefined') {
                try {
                    const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
                    const address = accounts[0];
                    
                    // Update UI
                    document.getElementById('wallet_address').value = address;
                    document.getElementById('wallet-address-display').innerText = `${address.slice(0, 6)}...${address.slice(-4)}`;
                    document.getElementById('wallet-connected').classList.remove('hidden');
                    document.getElementById('wallet-section').classList.add('border-emerald-200', 'bg-emerald-50');
                    document.getElementById('wallet-section').classList.remove('border-gray-200');
                    
                    // Update progress
                    document.getElementById('step1-indicator').classList.add('bg-white', 'text-purple-600');
                    document.getElementById('step1-indicator').classList.remove('bg-opacity-30');
                    document.getElementById('step1-indicator').innerHTML = '✓';
                    
                    // Enable upload section
                    document.getElementById('upload-section').classList.remove('opacity-50', 'pointer-events-none');
                    
                    connectBtn.style.display = 'none';
                    isWalletConnected = true;
                    
                } catch (error) {
                    console.error(error);
                    alert('Wallet connection failed. Please try again.');
                    connectBtn.innerHTML = originalText;
                    connectBtn.disabled = false;
                }
            } else {
                alert('MetaMask not detected. Please install MetaMask to continue.');
                connectBtn.innerHTML = originalText;
                connectBtn.disabled = false;
            }
        }

        // File Upload Enhancement
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('certificate');
        const uploadPlaceholder = document.getElementById('upload-placeholder');
        const filePreview = document.getElementById('file-preview');
        const fileName = document.getElementById('file-name');
        const fileSize = document.getElementById('file-size');

        // Click to upload
        dropZone.addEventListener('click', () => fileInput.click());

        // Drag and drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-blue-400', 'bg-blue-50');
        });

        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-blue-400', 'bg-blue-50');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-blue-400', 'bg-blue-50');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect(files[0]);
            }
        });

        // File input change
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFileSelect(e.target.files[0]);
            }
        });

        function handleFileSelect(file) {
            // Validate file type
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please select a valid file type (PDF, JPG, PNG)');
                return;
            }

            // Validate file size (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('File size must be less than 10MB');
                return;
            }

            // Show file preview
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            uploadPlaceholder.classList.add('hidden');
            filePreview.classList.remove('hidden');
            
            dropZone.classList.add('border-emerald-300', 'bg-emerald-50');
            dropZone.classList.remove('border-gray-300');
        }

        function clearFile() {
            fileInput.value = '';
            uploadPlaceholder.classList.remove('hidden');
            filePreview.classList.add('hidden');
            dropZone.classList.remove('border-emerald-300', 'bg-emerald-50');
            dropZone.classList.add('border-gray-300');
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!isWalletConnected) {
                e.preventDefault();
                alert('Please connect your wallet first.');
                return;
            }
            
            // Show loading state on submit
            const submitBtn = document.getElementById('submit-btn');
            submitBtn.innerHTML = `
                <span class="flex items-center justify-center">
                    <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Uploading to IPFS...
                </span>
            `;
            submitBtn.disabled = true;
        });
    </script>
</x-app-layout>