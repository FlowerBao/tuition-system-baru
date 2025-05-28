<x-app-layout>
    <x-slot name="header">  
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Tutor Details') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Quick Stats Card -->
            <div class="mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 max-w-sm">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Total Tutors</h3>
                            <p class="text-2xl font-bold text-gray-900">
                                @if(method_exists($tutorList, 'total'))
                                    {{ $tutorList->total() }}
                                @else
                                    {{ count($tutorList) }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                
                <!-- Header Section -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Tutor Directory</h3>
                            <p class="text-sm text-gray-600">Manage and monitor all tutors</p>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3">
                            <button onclick="generateReport()" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Generate Report
                            </button>
                            <button onclick="exportData()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Export
                            </button>
                            <a href="{{ route('tutors.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add New Tutor
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="px-6 py-4 bg-white border-b border-gray-200">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search tutors..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        
                        <select name="level_filter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Levels</option>
                            <option value="Primary" {{ request('level_filter') == 'Primary' ? 'selected' : '' }}>Primary</option>
                            <option value="Secondary" {{ request('level_filter') == 'Secondary' ? 'selected' : '' }}>Secondary</option>
                            <option value="Pre-University" {{ request('level_filter') == 'Pre-University' ? 'selected' : '' }}>Pre-University</option>
                            <option value="University" {{ request('level_filter') == 'University' ? 'selected' : '' }}>University</option>
                        </select>
                        
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                Filter
                            </button>
                            <a href="{{ route('tutors.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>

                @if(session('success'))
                    <div class="mx-6 mt-4 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Table Section -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <button class="flex items-center space-x-1 hover:text-gray-700">
                                        <span>Tutor Information</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    </button>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject Assignment</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tutorList as $tutor)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <!-- Tutor Information -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-semibold text-lg">
                                                    {{ strtoupper(substr($tutor->tutor_name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $tutor->tutor_name }}</div>
                                                <div class="text-sm text-gray-500">IC: {{ $tutor->tutor_ic }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Contact Details -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div class="flex items-center mb-1">
                                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $tutor->tutor_email }}
                                            </div>
                                            <div class="flex items-center mb-1">
                                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                                {{ $tutor->tutor_phone }}
                                            </div>
                                            <div class="flex items-start">
                                                <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span class="text-xs">{{ Str::limit($tutor->tutor_address, 50) }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Subject Assignment -->
                                    <td class="px-6 py-4">
                                        @if($tutor->subject)
                                            <div class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium inline-block">
                                                {{ $tutor->subject->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Level: {{ $tutor->subject->level }} | Class: {{ $tutor->subject->subject_class }}
                                            </div>
                                        @else
                                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm">
                                                No subject assigned
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4">
                                        @if($tutor->subject)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <span class="w-2 h-2 bg-green-400 rounded-full mr-1.5"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-1.5"></span>
                                                Available
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center space-x-3">
                                            
                                            
                                            <a href="{{ route('tutors.edit', $tutor->id) }}" class="text-indigo-600 hover:text-indigo-800 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>

                                            <form action="{{ route('tutors.destroy', $tutor->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this tutor? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No tutors found</h3>
                                            <p class="text-gray-500 mb-4">Get started by adding your first tutor.</p>
                                            <a href="{{ route('tutors.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Add New Tutor
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(method_exists($tutorList, 'links'))
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $tutorList->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Report Modal -->
    <div id="reportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center">
            <div class="bg-white rounded-lg shadow-xl transform transition-all max-w-4xl w-full">
                <div class="bg-white px-4 pt-5 pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Tutor Management Report</h3>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div id="reportContent">
                        <!-- Report content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generateReport() {
            document.getElementById('reportModal').classList.remove('hidden');
            
            // Sample report data - replace with actual data from backend
            const reportContent = `
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900">Total Tutors</h4>
                            <p class="text-2xl font-bold text-blue-600">${document.querySelectorAll('tbody tr').length > 0 ? document.querySelectorAll('tbody tr').length - 1 : 0}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="font-semibold mb-3">Performance Summary</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">
                                Generated on: ${new Date().toLocaleString()}<br>
                                This report provides an overview of the current tutor management system status.
                            </p>
                        </div>
                        
                        <div class="mt-4">
                            <h5 class="font-medium mb-2">Level Distribution</h5>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded">
                                    <span class="text-sm">Primary Level</span>
                                    <span class="text-sm font-medium">-- tutors</span>
                                </div>
                                <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded">
                                    <span class="text-sm">Secondary Level</span>
                                    <span class="text-sm font-medium">-- tutors</span>
                                </div>
                                <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded">
                                    <span class="text-sm">Pre-University Level</span>
                                    <span class="text-sm font-medium">-- tutors</span>
                                </div>
                                <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded">
                                    <span class="text-sm">University Level</span>
                                    <span class="text-sm font-medium">-- tutors</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <h5 class="font-medium mb-2">Recommendations</h5>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Consider recruiting more tutors for high-demand levels</li>
                                <li>• Review unassigned tutors for potential subject matching</li>
                                <li>• Regular performance evaluations recommended</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-6">
                        <button onclick="printReport()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 mr-2">
                            Print Report
                        </button>
                        <button onclick="downloadReport()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                            Download PDF
                        </button>
                    </div>
                </div>
            `;
            
            document.getElementById('reportContent').innerHTML = reportContent;
        }

        function closeModal() {
            document.getElementById('reportModal').classList.add('hidden');
        }

        function viewTutor(tutorId) {
            // Implement view tutor details functionality
            alert('View tutor details for ID: ' + tutorId);
        }

        function exportData() {
            // Sample export functionality
            const csvContent = "data:text/csv;charset=utf-8," 
                + "Name,IC,Email,Phone,Address,Subject,Status\n"
                + Array.from(document.querySelectorAll('tbody tr')).slice(0, -1).map(row => {
                    const cells = row.querySelectorAll('td');
                    if (cells.length > 0) {
                        const name = cells[0].querySelector('.text-sm.font-medium')?.textContent || '';
                        const ic = cells[0].querySelector('.text-sm.text-gray-500')?.textContent.replace('IC: ', '') || '';
                        const email = cells[1].querySelector('div:first-child')?.textContent.trim() || '';
                        const phone = cells[1].querySelector('div:nth-child(2)')?.textContent.trim() || '';
                        const address = cells[1].querySelector('div:nth-child(3) span')?.textContent || '';
                        const subject = cells[2].querySelector('.bg-indigo-100')?.textContent || 'Unassigned';
                        const status = cells[3].querySelector('span')?.textContent.trim() || '';
                        return `"${name}","${ic}","${email}","${phone}","${address}","${subject}","${status}"`;
                    }
                    return '';
                }).filter(row => row).join("\n");

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "tutors_export_" + new Date().toISOString().split('T')[0] + ".csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function printReport() {
            const reportContent = document.getElementById('reportContent').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Tutor Management Report</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; }
                            .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px; }
                            .bg-blue-50, .bg-green-50, .bg-yellow-50 { padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb; }
                            .text-2xl { font-size: 24px; font-weight: bold; }
                            .font-semibold { font-weight: 600; }
                            .space-y-2 > * + * { margin-top: 8px; }
                            .bg-gray-50 { background-color: #f9fafb; padding: 10px; border-radius: 4px; }
                            @media print { button { display: none; } }
                        </style>
                    </head>
                    <body>
                        <h1>Tutor Management Report</h1>
                        ${reportContent}
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }

        function downloadReport() {
            // Simple PDF generation simulation
            alert('PDF download functionality would be implemented with a PDF library like jsPDF or server-side generation.');
        }

        // Close modal when clicking outside
        document.getElementById('reportModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Enhanced search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    // Implement real-time search if needed
                    // This would typically be handled server-side with AJAX
                });
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case 'n':
                        e.preventDefault();
                        window.location.href = '{{ route("tutors.create") }}';
                        break;
                    case 'f':
                        e.preventDefault();
                        document.querySelector('input[name="search"]').focus();
                        break;
                    case 'r':
                        e.preventDefault();
                        generateReport();
                        break;
                }
            }
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>

    <style>
        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Animation for modal */
        #reportModal {
            animation: fadeIn 0.3s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        #reportModal > div > div {
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Hover effects */
        .hover\:scale-105:hover {
            transform: scale(1.05);
        }
        
        /* Status indicators animation */
        .bg-green-100 .w-2,
        .bg-yellow-100 .w-2 {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Loading state */
        .loading {
            position: relative;
            overflow: hidden;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Responsive table improvements */
        @media (max-width: 768px) {
            .min-w-full {
                min-width: 600px;
            }
        }
    </style>
</x-app-layout>