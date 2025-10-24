@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Manage Expenditures</h2>
        
        <!-- Total Spent Card -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4 border-l-4 border-red-500">
            <div class="flex items-center">
                <div class="text-red-600 font-semibold">Total Spent:</div>
                <div class="ml-2 text-xl font-bold text-gray-800">
                    ₱{{ isset($totalSpent) ? number_format($totalSpent, 2) : '0.00' }}
                </div>
            </div>
        </div>

       <!-- Action Buttons -->
<div class="flex gap-3 flex-wrap">
    <!-- Add Button -->
    <button onclick="window.location.href='{{ route('admin.expenditure.create') }}'" 
            class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
        <span class="text-lg">+</span>
        ADD EXPENDITURE
    </button>
    
    <!-- Print Report Button -->
    <a href="{{ route('admin.reports.print') }}" target="_blank"
       class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-4 0h-4m0 0v4m0-4h4m-4 0H8" />
        </svg>
        PRINT REPORT
    </a>
</div>
            
    <!-- Expenditure Records Section -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Section Header -->
        <div class="bg-gray-800 text-white p-4">
            <h3 class="text-lg font-semibold flex items-center gap-2">
                <span class="text-xl">≡</span>
                Expenditure Records
            </h3>
        </div>

        <!-- Table Header -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
            <div class="grid grid-cols-12 gap-4 p-4 font-semibold">
                <div class="col-span-1">ID</div>
                <div class="col-span-2">TITLE</div>
                <div class="col-span-2">CATEGORY</div>
                <div class="col-span-2">AMOUNT (₱)</div>
                <div class="col-span-2">DATE</div>
                <div class="col-span-1">RECEIPT</div>
                <div class="col-span-2">ACTIONS</div>
            </div>
        </div>

        <!-- Table Body -->
        <div class="divide-y divide-gray-200" id="expenditure-table-body">
            @forelse($expenditures as $exp)
            <div class="grid grid-cols-12 gap-4 p-4 hover:bg-gray-50 transition-colors duration-150 {{ session('new_expenditure_id') == $exp->id ? 'bg-green-50 border-l-4 border-green-500' : '' }}">
                <!-- ID -->
                <div class="col-span-1 flex items-center font-medium text-gray-900">
                    {{ $exp->id }}
                </div>
                
                <!-- Title -->
                <div class="col-span-2 flex items-center text-gray-700">
                    <div class="truncate" title="{{ $exp->title }}">
                        {{ $exp->title ?? 'N/A' }}
                    </div>
                </div>
                
                <!-- Category -->
                <div class="col-span-2 flex items-center text-gray-700">
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full 
                        @switch($exp->category)
                            @case('Infrastructure')
                                bg-blue-100 text-blue-800
                                @break
                            @case('Education')
                                bg-green-100 text-green-800
                                @break
                            @case('Healthcare')
                                bg-red-100 text-red-800
                                @break
                            @case('Public Safety')
                                bg-yellow-100 text-yellow-800
                                @break
                            @case('Utilities')
                                bg-purple-100 text-purple-800
                                @break
                            @default
                                bg-gray-100 text-gray-800
                        @endswitch">
                        {{ $exp->category ?? 'N/A' }}
                    </span>
                </div>
                
                <!-- Amount -->
                <div class="col-span-2 flex items-center font-semibold text-gray-900">
                    ₱{{ number_format($exp->amount, 2) }}
                </div>
                
                <!-- Date -->
                <div class="col-span-2 flex items-center text-gray-600">
                    {{ $exp->date ? \Carbon\Carbon::parse($exp->date)->format('M d, Y') : ($exp->created_at ? $exp->created_at->format('M d, Y') : 'N/A') }}
                </div>
                
                <!-- Receipt Preview & Action -->
                <div class="col-span-1 flex items-center">
                    @if(method_exists($exp, 'hasReceipt') && $exp->hasReceipt())
                        @php
                            $receiptUrl = $exp->receipt_url ?? asset('storage/' . ($exp->receipt ?? $exp->receipt_path));
                            $isImage = method_exists($exp, 'isReceiptImage') ? $exp->isReceiptImage() : false;
                        @endphp
                        
                        <div class="flex flex-col items-center gap-1">
                            <!-- Receipt Thumbnail (for images only) -->
                            @if($isImage)
                                <div class="w-12 h-12 rounded-lg overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer"
                                     onclick="viewReceiptModal('{{ $receiptUrl }}', '{{ addslashes($exp->title) }}', {{ $exp->id }})">
                                    <img src="{{ $receiptUrl }}" 
                                         alt="Receipt thumbnail" 
                                         class="w-full h-full object-cover hover:scale-110 transition-transform duration-200"
                                         loading="lazy"
                                         onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gray-200 flex items-center justify-center text-xs text-gray-500\'>Error</div>'">
                                </div>
                            @else
                                <div class="w-12 h-12 rounded-lg border border-gray-200 bg-red-50 flex items-center justify-center cursor-pointer hover:shadow-md transition-shadow"
                                     onclick="window.open('{{ route('admin.expenditure.showReceipt', $exp->id) }}', '_blank')">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- View Button -->
                            <button onclick="window.open('{{ route('admin.expenditure.showReceipt', $exp->id) }}', '_blank')"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs font-medium transition-colors duration-200 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                VIEW
                            </button>
                        </div>
                    @elseif($exp->receipt || $exp->receipt_path)
                        @php
                            $receiptUrl = asset('storage/' . ($exp->receipt ?? $exp->receipt_path));
                        @endphp
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-12 h-12 rounded-lg overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer"
                                 onclick="viewReceiptModal('{{ $receiptUrl }}', '{{ addslashes($exp->title) }}', {{ $exp->id }})">
                                <img src="{{ $receiptUrl }}" 
                                     alt="Receipt thumbnail" 
                                     class="w-full h-full object-cover hover:scale-110 transition-transform duration-200"
                                     loading="lazy"
                                     onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gray-200 flex items-center justify-center text-xs text-gray-500\'>Error</div>'">
                            </div>
                            
                           
                        </div>
                    @else
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <span class="text-xs text-gray-500 mt-1">No Receipt</span>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="col-span-2 flex items-center gap-2">
                    <!-- Edit Button -->
                    <a href="{{ route('admin.expenditure.edit', $exp->id) }}" 
                       class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-colors duration-200 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        EDIT
                    </a>
                    
                    <!-- Delete Button -->
                    <button type="button"
                            onclick="confirmDelete({{ $exp->id }})"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-colors duration-200 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        DELETE
                    </button>
                    
                    <!-- Hidden Delete Form -->
                    <form id="delete-form-{{ $exp->id }}" action="{{ route('admin.expenditure.destroy', $exp->id) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">
                <div class="text-4xl mb-2">📊</div>
                <div class="text-lg font-medium">No expenditures found</div>
                <div class="text-sm">Click "ADD EXPENDITURE" to get started</div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Receipt Modal (for thumbnails) -->
<div id="receiptModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-4xl max-h-[90vh] overflow-hidden w-full">
        <div class="flex justify-between items-center p-4 border-b bg-gray-50">
            <h3 id="receiptTitle" class="text-xl font-semibold text-gray-800">Receipt Preview</h3>
            <div class="flex items-center gap-2">
                
                <button onclick="closeReceiptModal()" class="text-gray-500 hover:text-gray-700 text-3xl font-bold leading-none">
                    ×
                </button>
            </div>
        </div>
        <div class="p-6 overflow-auto max-h-[70vh] bg-gray-100 flex items-center justify-center">
            <div class="max-w-full max-h-full">
                <img id="receiptImage" src="" alt="Receipt Preview" 
                     class="max-w-full max-h-full object-contain rounded-lg shadow-lg bg-white"
                     onload="imageLoaded()" onerror="imageError()">
                <div id="loadingSpinner" class="flex items-center justify-center p-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                    <span class="ml-3 text-gray-600">Loading image...</span>
                </div>
                <div id="errorMessage" class="hidden flex flex-col items-center justify-center p-8 text-center">
                    <div class="text-6xl mb-4">📄</div>
                    <p class="text-gray-600 text-lg">Unable to display receipt</p>
                    <p class="text-gray-500 text-sm mt-2">Click "Full View" to open in a new tab</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let currentReceiptUrl = '';
let currentExpenditureId = '';

function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete the expenditure and its receipt.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-lg',
            confirmButton: 'rounded-md',
            cancelButton: 'rounded-md'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

function viewReceiptModal(imageUrl, title, expenditureId) {
    currentReceiptUrl = imageUrl;
    currentExpenditureId = expenditureId;
    
    // Reset modal state
    document.getElementById('receiptImage').style.display = 'block';
    document.getElementById('loadingSpinner').style.display = 'flex';
    document.getElementById('errorMessage').classList.add('hidden');
    
    // Set image source and title
    document.getElementById('receiptImage').src = imageUrl;
    document.getElementById('receiptTitle').textContent = 'Receipt - ' + title;
    
    // Show modal
    document.getElementById('receiptModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function imageLoaded() {
    document.getElementById('loadingSpinner').style.display = 'none';
    document.getElementById('receiptImage').style.display = 'block';
    document.getElementById('errorMessage').classList.add('hidden');
}

function imageError() {
    document.getElementById('loadingSpinner').style.display = 'none';
    document.getElementById('receiptImage').style.display = 'none';
    document.getElementById('errorMessage').classList.remove('hidden');
}

function closeReceiptModal() {
    document.getElementById('receiptModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('receiptImage').src = '';
}

function openFullReceipt() {
    if (currentExpenditureId) {
        window.open('{{ url("/admin/expenditures") }}/' + currentExpenditureId + '/view-receipt', '_blank');
    }
}
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false,
        customClass: {
            popup: 'rounded-lg'
        }
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        customClass: {
            popup: 'rounded-lg'
        }
    });
</script>
@endif

@endsection