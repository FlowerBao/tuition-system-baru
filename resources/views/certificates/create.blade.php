<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Tutor Certificate') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <input type="file" id="certificateFile" accept=".pdf,.jpg,.jpeg,.png" class="block mb-4" />

                <button id="connectWallet"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4">
                    Connect MetaMask Wallet
                </button>

                <br>

                <button id="uploadAndIssue" disabled
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Upload & Issue Certificate
                </button>

                <div id="status" class="mt-4 text-sm text-gray-700"></div>
            </div>
        </div>
    </div>

    <!-- Include ethers.js -->
    <script src="https://cdn.jsdelivr.net/npm/ethers@5.7.2/dist/ethers.min.js"></script>

    <script>
        let provider;
        let signer;
        let contract;

        const contractAddress = "YOUR_DEPLOYED_CONTRACT_ADDRESS";

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

        document.getElementById('connectWallet').onclick = async () => {
            if (window.ethereum) {
                try {
                    await window.ethereum.request({ method: 'eth_requestAccounts' });
                    provider = new ethers.providers.Web3Provider(window.ethereum);
                    signer = provider.getSigner();
                    contract = new ethers.Contract(contractAddress, contractABI, signer);
                    document.getElementById('status').innerText = "Wallet connected: " + await signer.getAddress();
                    document.getElementById('uploadAndIssue').disabled = false;
                } catch (error) {
                    alert('User rejected wallet connection');
                }
            } else {
                alert('Please install MetaMask!');
            }
        };

        document.getElementById('uploadAndIssue').onclick = async () => {
            const fileInput = document.getElementById('certificateFile');
            if (fileInput.files.length === 0) {
                alert('Please select a certificate file to upload.');
                return;
            }

            const file = fileInput.files[0];
            document.getElementById('status').innerText = "Uploading certificate to IPFS...";

            const formData = new FormData();
            formData.append('certificate', file);

            try {
                const response = await fetch("{{ route('certificates.upload-ipfs') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    body: formData
                });

                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'IPFS upload failed');

                const ipfsHash = data.ipfs_hash;
                document.getElementById('status').innerText = "IPFS upload successful: " + ipfsHash;

                const tutorAddress = await signer.getAddress();
                document.getElementById('status').innerText = "Issuing certificate on blockchain...";

                const tx = await contract.issueCertificate(tutorAddress, ipfsHash);
                await tx.wait();

                document.getElementById('status').innerText = "Certificate issued successfully! Transaction Hash: " + tx.hash;
            } catch (err) {
                document.getElementById('status').innerText = "Error: " + err.message;
            }
        };
    </script>
</x-app-layout>
