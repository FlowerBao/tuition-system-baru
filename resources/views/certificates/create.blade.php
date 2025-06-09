<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <button onclick="history.back()" class="flex items-center space-x-2 text-gray-600 hover:text-gray-800 transition-colors duration-200 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-lg">
                    <i class="fas fa-arrow-left"></i>
                    <span class="hidden sm:inline">Back</span>
                </button>
                <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
                    {{ __('Tutor Certificate Upload') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <!-- Add required styles and scripts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        .upload-area {
            border: 2px dashed #e5e7eb;
            transition: all 0.3s ease;
        }
        
        .upload-area:hover {
            border-color: #3b82f6;
            background-color: #f8fafc;
        }
        
        .upload-area.dragover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        
        .progress-bar {
            width: 0%;
            transition: width 0.3s ease;
        }
        
        .status-card {
            transform: translateY(10px);
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .status-card.show {
            transform: translateY(0);
            opacity: 1;
        }
        
        .wallet-connected::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #10b981, #3b82f6);
            border-radius: 12px;
            z-index: -1;
        }
        
        .pulse-ring {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(0.95); opacity: 1; }
            70% { transform: scale(1); opacity: 0.7; }
            100% { transform: scale(0.95); opacity: 1; }
        }
    </style>

    <div class="py-12">
        <h2 class="text-2xl font-bold">Tutor Certificate Upload</h2>
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Wallet Connection Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                                <i class="fab fa-ethereum text-orange-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">MetaMask Wallet</h3>
                                <p class="text-gray-600 text-sm">Connect your wallet to proceed</p>
                            </div>
                        </div>
                        <div id="walletStatus" class="flex items-center space-x-2">
                            <div id="connectionIndicator" class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span id="connectionText" class="text-sm text-gray-600">Disconnected</span>
                        </div>
                    </div>
                    
                    <button id="connectWallet" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 transition-all duration-200 flex items-center justify-center space-x-2 shadow-lg">
                        <i class="fas fa-wallet"></i>
                        <span>Connect MetaMask Wallet</span>
                    </button>
                    
                    <div id="walletInfo" class="hidden mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <span class="text-green-800 font-medium">Wallet Connected</span>
                        </div>
                        <p id="walletAddress" class="text-sm text-green-700 mt-1 font-mono break-all"></p>
                    </div>
                </div>
            </div>

            <!-- Certificate Upload Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-cloud-upload-alt text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Upload Certificate</h3>
                            <p class="text-gray-600 text-sm">Select your certificate file to upload</p>
                        </div>
                    </div>

                    <!-- File Upload Area -->
                    <div id="uploadArea" class="upload-area p-8 rounded-xl text-center cursor-pointer mb-6">
                        <div class="flex flex-col items-center space-y-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-upload text-blue-600 text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-lg font-medium text-gray-700">Drop your certificate here</p>
                                <p class="text-gray-500">or <span class="text-blue-600 hover:text-blue-700 font-medium">browse files</span></p>
                                <p class="text-sm text-gray-400 mt-2">Supports PDF, JPG, JPEG, PNG (Max 10MB)</p>
                            </div>
                        </div>
                        <input type="file" id="certificateFile" accept=".pdf,.jpg,.jpeg,.png" class="hidden" />
                    </div>

                    <!-- Selected File Info -->
                    <div id="fileInfo" class="hidden mb-6 p-4 bg-gray-50 rounded-lg border">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <i id="fileIcon" class="fas fa-file text-gray-600 text-xl"></i>
                                <div>
                                    <p id="fileName" class="font-medium text-gray-800"></p>
                                    <p id="fileSize" class="text-sm text-gray-600"></p>
                                </div>
                            </div>
                            <button id="removeFile" class="text-red-600 hover:text-red-700 p-2">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Upload Button -->
                   <button id="uploadAndIssue" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-3 rounded-lg font-medium hover:from-green-700 hover:to-emerald-700 transition-all duration-200 flex items-center justify-center space-x-2 shadow-lg">
                    <i class="fas fa-certificate"></i>
                        <span>Upload & Issue Certificate</span>
                    </button>
                </div>
            </div>

            <!-- Status Card -->
            <div id="statusCard" class="status-card bg-white overflow-hidden shadow-xl sm:rounded-lg hidden">
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div id="statusIcon" class="w-12 h-12 rounded-xl flex items-center justify-center">
                            <i class="fas fa-info-circle text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 id="statusTitle" class="text-lg font-semibold text-gray-900">Processing</h3>
                            <p id="statusMessage" class="text-gray-600 text-sm">Please wait...</p>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div id="progressContainer" class="hidden mb-4">
                        <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                            <div id="progressBar" class="progress-bar bg-gradient-to-r from-blue-500 to-purple-500 h-3 rounded-full"></div>
                        </div>
                        <p id="progressText" class="text-sm text-gray-600 text-center font-medium">0%</p>
                    </div>
                    
                    <!-- Transaction Hash -->
                    <div id="transactionInfo" class="hidden p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-link text-green-600 mt-0.5"></i>
                            <div class="flex-1">
                                <p class="text-sm text-green-800 font-medium">Transaction Hash:</p>
                                <p id="transactionHash" class="text-xs text-green-700 font-mono break-all mt-1 bg-green-100 p-2 rounded"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include ethers.js -->
    <script src="https://cdn.jsdelivr.net/npm/ethers@5.7.2/dist/ethers.min.js"></script>

    <script>
        let provider;
        let signer;
        let contract;

        // Replace with your deployed contract address
        const contractAddress = "0x9F5D3F131d9A34E6e30fEA4eb5a6F7F3f1d8E1d6";

        const contractABI = [
            {
                "inputs":[{"internalType":"address","name":"tutor","type":"address"},{"internalType":"string","name":"ipfsHash","type":"string"}],
                "name":"issueCertificate",
                "outputs":[],
                "stateMutability":"nonpayable",
                "type":"function"
            },
            {
                "inputs":[{"internalType":"address","name":"tutor","type":"address"}],
                "name":"getCertificatesByTutor",
                "outputs":[{"internalType":"uint256[]","name":"","type":"uint256[]"}],
                "stateMutability":"view",
                "type":"function"
            },
            {
                "inputs":[{"internalType":"uint256","name":"id","type":"uint256"}],
                "name":"getCertificate",
                "outputs":[
                    {"components":[
                        {"internalType":"uint256","name":"id","type":"uint256"},
                        {"internalType":"address","name":"tutor","type":"address"},
                        {"internalType":"string","name":"ipfsHash","type":"string"},
                        {"internalType":"uint256","name":"timestamp","type":"uint256"}
                    ],
                    "internalType":"struct TutorCertificates.Certificate",
                    "name":"",
                    "type":"tuple"}
                ],
                "stateMutability":"view",
                "type":"function"
            }
        ];

        // DOM Elements
        const connectWalletBtn = document.getElementById('connectWallet');
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('certificateFile');
        const fileInfo = document.getElementById('fileInfo');
        const uploadBtn = document.getElementById('uploadAndIssue');
        const statusCard = document.getElementById('statusCard');

        // File upload event listeners
        uploadArea.addEventListener('click', () => fileInput.click());
        uploadArea.addEventListener('dragover', handleDragOver);
        uploadArea.addEventListener('dragleave', handleDragLeave);
        uploadArea.addEventListener('drop', handleDrop);
        fileInput.addEventListener('change', handleFileSelect);
        document.getElementById('removeFile').addEventListener('click', clearFile);

        function handleDragOver(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        }

        function handleDragLeave(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        }

        function handleDrop(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFile(files[0]);
            }
        }

        function handleFileSelect(e) {
            if (e.target.files.length > 0) {
                handleFile(e.target.files[0]);
            }
        }

        function handleFile(file) {
            const maxSize = 10 * 1024 * 1024; // 10MB
            if (file.size > maxSize) {
                showStatus('error', 'File Too Large', 'Please select a file under 10MB');
                return;
            }

            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const fileIcon = document.getElementById('fileIcon');

            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            
            // Set appropriate icon based on file type
            if (file.type.includes('pdf')) {
                fileIcon.className = 'fas fa-file-pdf text-red-600 text-xl';
            } else if (file.type.includes('image')) {
                fileIcon.className = 'fas fa-file-image text-green-600 text-xl';
            } else {
                fileIcon.className = 'fas fa-file text-gray-600 text-xl';
            }

            fileInfo.classList.remove('hidden');
            uploadArea.classList.add('hidden');
        }

        function clearFile() {
            fileInput.value = '';
            fileInfo.classList.add('hidden');
            uploadArea.classList.remove('hidden');
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Wallet Connection
        connectWalletBtn.addEventListener('click', async () => {
            if (window.ethereum) {
                try {
                    showStatus('loading', 'Connecting Wallet', 'Please approve the connection in MetaMask');
                    
                    await window.ethereum.request({ method: 'eth_requestAccounts' });
                    provider = new ethers.providers.Web3Provider(window.ethereum);
                    signer = provider.getSigner();
                    contract = new ethers.Contract(contractAddress, contractABI, signer);
                    
                    const address = await signer.getAddress();
                    updateWalletUI(address);
                    uploadBtn.disabled = false;
                    
                    hideStatus();
                    
                } catch (error) {
                    showStatus('error', 'Connection Failed', 'User rejected wallet connection or error occurred');
                    console.error('Wallet connection error:', error);
                }
            } else {
                showStatus('error', 'MetaMask Not Found', 'Please install MetaMask extension to continue');
            }
        });

        function updateWalletUI(address) {
            document.getElementById('connectionIndicator').className = 'w-3 h-3 bg-green-500 rounded-full pulse-ring';
            document.getElementById('connectionText').textContent = 'Connected';
            document.getElementById('walletAddress').textContent = `Address: ${address}`;
            document.getElementById('walletInfo').classList.remove('hidden');
            connectWalletBtn.innerHTML = '<i class="fas fa-check-circle"></i><span>Wallet Connected</span>';
            connectWalletBtn.disabled = true;
            connectWalletBtn.classList.add('from-green-600', 'to-green-700');
            connectWalletBtn.classList.remove('from-blue-600', 'to-purple-600');
        }

        // Upload and Issue Certificate
        uploadBtn.addEventListener('click', async () => {
            if (fileInput.files.length === 0) {
                showStatus('error', 'No File Selected', 'Please select a certificate file to upload');
                return;
            }

            const file = fileInput.files[0];
            
            try {
                // Step 1: Upload to IPFS
                showStatus('loading', 'Uploading to IPFS', 'Uploading certificate to decentralized storage...');
                showProgress(25);

                const formData = new FormData();
                formData.append('certificate', file);

                const response = await fetch("{{ route('certificates.upload-ipfs') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    body: formData
                });

                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'IPFS upload failed');

                showProgress(60);
                const ipfsHash = data.ipfs_hash;

                // Step 2: Issue certificate on blockchain
                showStatus('loading', 'Issuing Certificate', 'Creating blockchain transaction...');
                showProgress(80);

                const tutorAddress = await signer.getAddress();
                const tx = await contract.issueCertificate(tutorAddress, ipfsHash);
                
                showStatus('loading', 'Confirming Transaction', 'Waiting for blockchain confirmation...');
                await tx.wait();

                showProgress(100);
                
                // Success
                showStatus('success', 'Certificate Issued Successfully!', `Certificate has been uploaded to IPFS and recorded on blockchain`);
                document.getElementById('transactionHash').textContent = tx.hash;
                document.getElementById('transactionInfo').classList.remove('hidden');
                
                // Reset form after 5 seconds
                setTimeout(() => {
                    clearFile();
                    hideStatus();
                }, 5000);

            } catch (error) {
                console.error('Upload error:', error);
                showStatus('error', 'Transaction Failed', error.message || 'An error occurred during the process');
            }
        });

        function showStatus(type, title, message) {
            const card = statusCard;
            const icon = document.getElementById('statusIcon');
            const titleEl = document.getElementById('statusTitle');
            const messageEl = document.getElementById('statusMessage');

            // Reset classes
            icon.className = 'w-12 h-12 rounded-xl flex items-center justify-center';
            
            switch (type) {
                case 'loading':
                    icon.classList.add('bg-blue-100');
                    icon.innerHTML = '<i class="fas fa-spinner fa-spin text-blue-600 text-xl"></i>';
                    break;
                case 'success':
                    icon.classList.add('bg-green-100');
                    icon.innerHTML = '<i class="fas fa-check-circle text-green-600 text-xl"></i>';
                    hideProgress();
                    break;
                case 'error':
                    icon.classList.add('bg-red-100');
                    icon.innerHTML = '<i class="fas fa-exclamation-circle text-red-600 text-xl"></i>';
                    hideProgress();
                    break;
            }

            titleEl.textContent = title;
            messageEl.textContent = message;
            card.classList.remove('hidden');
            card.classList.add('show');
        }

        function hideStatus() {
            statusCard.classList.remove('show');
            setTimeout(() => {
                statusCard.classList.add('hidden');
                document.getElementById('transactionInfo').classList.add('hidden');
            }, 300);
        }

        function showProgress(percentage) {
            const container = document.getElementById('progressContainer');
            const bar = document.getElementById('progressBar');
            const text = document.getElementById('progressText');
            
            container.classList.remove('hidden');
            bar.style.width = percentage + '%';
            text.textContent = percentage + '%';
        }

        function hideProgress() {
            document.getElementById('progressContainer').classList.add('hidden');
        }
    </script>
</x-app-layout>