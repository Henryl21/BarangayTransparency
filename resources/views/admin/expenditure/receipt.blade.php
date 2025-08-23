@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
        
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-3 rounded-full shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-slate-800">Receipt View</h1>
                        <p class="text-gray-600">{{ $expenditure->title ?? 'Expenditure Receipt' }}</p>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.expenditure.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                    
                    <a href="{{ route('admin.expenditure.receipt', $expenditure->id) }}" 
                       target="_blank"
                       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Expenditure Details Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Expenditure Details
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="text-sm font-medium text-gray-500">Title</label>
                    <p class="text-lg font-semibold text-gray-800">{{ $expenditure->title }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="text-sm font-medium text-gray-500">Category</label>
                    <p class="text-lg font-semibold text-gray-800">{{ $expenditure->category ?? 'N/A' }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="text-sm font-medium text-gray-500">Amount</label>
                    <p class="text-lg font-bold text-green-600">₱{{ number_format($expenditure->amount, 2) }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="text-sm font-medium text-gray-500">Date</label>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $expenditure->date ? \Carbon\Carbon::parse($expenditure->date)->format('M d, Y') : 'N/A' }}
                    </p>
                </div>
            </div>
            
            @if($expenditure->description)
            <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                <label class="text-sm font-medium text-gray-500">Description</label>
                <p class="text-gray-800 mt-1">{{ $expenditure->description }}</p>
            </div>
            @endif
        </div>

        <!-- Receipt Display Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4">
                <h3 class="text-lg font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Receipt Document
                </h3>
            </div>
            
            <div class="p-6">
                @if($expenditure->receipt)
                    @php
                        $receiptPath = $expenditure->receipt;
                        $receiptUrl = asset('storage/' . $receiptPath);
                        $isImage = in_array(strtolower(pathinfo($receiptPath, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']);
                    @endphp
                    
                    @if($isImage)
                        <!-- Image Receipt Display -->
                        <div class="flex justify-center bg-gray-100 p-4 rounded-lg">
                            <div class="max-w-full">
                                <img src="{{ $receiptUrl }}" 
                                     alt="Receipt for {{ $expenditure->title }}" 
                                     class="max-w-full h-auto rounded-lg shadow-lg cursor-pointer hover:shadow-xl transition-shadow duration-300"
                                     onclick="openImageFullscreen(this.src)"
                                     style="max-height: 80vh;">
                            </div>
                        </div>
                        
                        <!-- Image Info -->
                        <div class="mt-4 text-center text-sm text-gray-600">
                            <p>Click image to view in fullscreen</p>
                        </div>
                    @else
                        <!-- PDF Receipt Display -->
                        <div class="text-center">
                            <div class="bg-red-50 border border-red-200 rounded-lg p-8 mb-4">
                                <svg class="w-16 h-16 text-red-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <h3 class="text-lg font-semibold text-red-800 mb-2">PDF Document</h3>
                                <p class="text-red-600">{{ basename($receiptPath) }}</p>
                            </div>
                            
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('admin.expenditure.receipt', $expenditure->id) }}" 
                                   target="_blank"
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    Open PDF
                                </a>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- No Receipt -->
                    <div class="text-center py-12">
                        <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">No Receipt Available</h3>
                        <p class="text-gray-500 mb-6">This expenditure doesn't have an associated receipt.</p>
                        
                        <!-- Upload Receipt Button -->
                        <button onclick="showUploadModal()" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2 mx-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Upload Receipt
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen Image Modal -->
<div id="fullscreenModal" class="fixed inset-0 bg-black bg-opacity-90 hidden z-50 flex items-center justify-center p-4">
    <div class="relative max-w-full max-h-full">
        <button onclick="closeFullscreen()" 
                class="absolute top-4 right-4 text-white bg-black bg-opacity-50 hover:bg-opacity-75 rounded-full p-2 z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="fullscreenImage" src="" alt="Fullscreen Receipt" class="max-w-full max-h-full object-contain">
    </div>
</div>

<!-- Upload Receipt Modal -->
<div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-lg w-full p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Upload Receipt</h3>
            <button onclick="closeUploadModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form action="{{ route('admin.expenditure.storeReceipt', $expenditure->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Receipt File</label>
                <div class="flex items-center justify-center w-full">
                    <label for="receipt-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span></p>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG or PDF (MAX. 5MB)</p>
                        </div>
                        <input id="receipt-file" type="file" name="receipt" class="hidden" accept="image/*,.pdf" required>
                    </label>
                </div>
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeUploadModal()" 
                        class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Cancel
                </button>
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                    Upload Receipt
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openImageFullscreen(imageSrc) {
    document.getElementById('fullscreenImage').src = imageSrc;
    document.getElementById('fullscreenModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeFullscreen() {
    document.getElementById('fullscreenModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function showUploadModal() {
    document.getElementById('uploadModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeUploadModal() {
    document.getElementById('uploadModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modals when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const fullscreenModal = document.getElementById('fullscreenModal');
    const uploadModal = document.getElementById('uploadModal');
    
    if (fullscreenModal) {
        fullscreenModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeFullscreen();
            }
        });
    }
    
    if (uploadModal) {
        uploadModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeUploadModal();
            }
        });
    }
});

// Close modals with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeFullscreen();
        closeUploadModal();
    }
});
</script>

@endsection