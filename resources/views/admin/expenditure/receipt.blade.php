@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.expenditure.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Expenditures
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Receipt View</h2>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.expenditure.downloadReceipt', $expenditure->id) }}" 
                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download
                </a>
                
                <a href="{{ route('admin.expenditure.edit', $expenditure->id) }}" 
                   class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Expenditure
                </a>
            </div>
        </div>

        <!-- Expenditure Details Card -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">Title</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $expenditure->title }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Amount</label>
                    <p class="text-lg font-bold text-green-600">₱{{ number_format($expenditure->amount, 2) }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Category</label>
                    <p class="text-lg text-gray-900">{{ $expenditure->category ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Date</label>
                    <p class="text-lg text-gray-900">
                        {{ $expenditure->date ? \Carbon\Carbon::parse($expenditure->date)->format('M d, Y') : 'N/A' }}
                    </p>
                </div>
            </div>
            
            @if($expenditure->description)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <label class="text-sm font-medium text-gray-500">Description</label>
                <p class="text-gray-900 mt-1">{{ $expenditure->description }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Receipt Display Section -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-gray-800 text-white p-4">
            <h3 class="text-lg font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Receipt Document
                @if($expenditure->hasReceipt())
                    <span class="ml-2 text-sm bg-green-500 px-2 py-1 rounded">
                        {{ strtoupper($expenditure->getReceiptExtension()) }}
                        ({{ $expenditure->getReceiptFileSizeFormatted() }})
                    </span>
                @endif
            </h3>
        </div>

        <div class="p-6">
            @if($expenditure->hasReceipt())
                @if($isImage)
                    <!-- Image Receipt Display -->
                    <div class="flex justify-center bg-gray-100 rounded-lg p-4">
                        <div class="max-w-4xl max-h-screen overflow-auto">
                            <img src="{{ $receiptUrl }}" 
                                 alt="Receipt for {{ $expenditure->title }}" 
                                 class="max-w-full h-auto rounded-lg shadow-lg bg-white"
                                 style="max-height: 80vh;"
                                 onload="this.classList.remove('hidden'); document.getElementById('loading-{{ $expenditure->id }}').classList.add('hidden');"
                                 onerror="this.classList.add('hidden'); document.getElementById('error-{{ $expenditure->id }}').classList.remove('hidden'); document.getElementById('loading-{{ $expenditure->id }}').classList.add('hidden');">
                            
                            <!-- Loading Spinner -->
                            <div id="loading-{{ $expenditure->id }}" class="flex flex-col items-center justify-center p-12">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mb-4"></div>
                                <p class="text-gray-600">Loading receipt image...</p>
                            </div>
                            
                            <!-- Error Display -->
                            <div id="error-{{ $expenditure->id }}" class="hidden flex flex-col items-center justify-center p-12 text-center">
                                <div class="text-6xl mb-4">⚠️</div>
                                <p class="text-red-600 text-lg font-medium mb-2">Unable to load receipt image</p>
                                <p class="text-gray-600 mb-4">The file may be corrupted or moved.</p>
                                <a href="{{ route('admin.expenditure.downloadReceipt', $expenditure->id) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                    Try Download Instead
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- PDF Receipt Display -->
                    <div class="bg-gray-100 rounded-lg p-6 text-center">
                        <div class="mb-4">
                            <svg class="w-16 h-16 text-red-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900">PDF Receipt</h3>
                            <p class="text-gray-600">Click the button below to view the PDF receipt</p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3 justify-center items-center">
                            <a href="{{ route('admin.expenditure.receipt', $expenditure->id) }}" 
                               target="_blank"
                               class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-medium flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                View PDF in New Tab
                            </a>
                            
                            <a href="{{ route('admin.expenditure.downloadReceipt', $expenditure->id) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download PDF
                            </a>
                        </div>
                    </div>

                    <!-- Embedded PDF Viewer (optional) -->
                    <div class="mt-6">
                        <div class="bg-white rounded-lg shadow-inner" style="height: 600px;">
                            <iframe src="{{ route('admin.expenditure.receipt', $expenditure->id) }}" 
                                    class="w-full h-full rounded-lg border"
                                    title="PDF Receipt"
                                    onload="this.classList.remove('hidden'); document.getElementById('iframe-loading-{{ $expenditure->id }}').classList.add('hidden');"
                                    onerror="this.classList.add('hidden'); document.getElementById('iframe-error-{{ $expenditure->id }}').classList.remove('hidden'); document.getElementById('iframe-loading-{{ $expenditure->id }}').classList.add('hidden');">
                            </iframe>
                            
                            <!-- Iframe Loading -->
                            <div id="iframe-loading-{{ $expenditure->id }}" class="flex items-center justify-center h-full">
                                <div class="text-center">
                                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-red-500 mx-auto mb-2"></div>
                                    <p class="text-gray-600">Loading PDF...</p>
                                </div>
                            </div>
                            
                            <!-- Iframe Error -->
                            <div id="iframe-error-{{ $expenditure->id }}" class="hidden flex items-center justify-center h-full">
                                <div class="text-center">
                                    <p class="text-gray-600 mb-4">PDF cannot be displayed in this frame</p>
                                    <a href="{{ route('admin.expenditure.receipt', $expenditure->id) }}" 
                                       target="_blank"
                                       class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                        Open PDF in New Tab
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- No Receipt Available -->
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">📄</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Receipt Available</h3>
                    <p class="text-gray-600 mb-6">This expenditure doesn't have an associated receipt document.</p>
                    
                    <a href="{{ route('admin.expenditure.edit', $expenditure->id) }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Upload Receipt
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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