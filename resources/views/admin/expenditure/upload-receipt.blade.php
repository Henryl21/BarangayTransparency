@extends('layouts.admin')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow rounded">
    <!-- Header with back button -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">
            @if($expenditure->receipt_path)
                Update Receipt for Expenditure #{{ $expenditure->id }}
            @else
                Upload Receipt for Expenditure #{{ $expenditure->id }}
            @endif
        </h2>
        <a href="{{ route('admin.expenditure.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1.5 rounded-md text-sm font-medium transition-colors duration-200">
            ← Back to List
        </a>
    </div>

    <!-- Expenditure Details Card -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <h3 class="font-medium text-gray-900 mb-2">Expenditure Details</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-600">Category:</span>
                <span class="font-medium">{{ $expenditure->category ?? 'N/A' }}</span>
            </div>
            <div>
                <span class="text-gray-600">Amount:</span>
                <span class="font-medium">₱{{ number_format($expenditure->amount, 2) }}</span>
            </div>
            <div>
                <span class="text-gray-600">Date:</span>
                <span class="font-medium">
                    {{ $expenditure->date ? \Carbon\Carbon::parse($expenditure->date)->format('M d, Y') : ($expenditure->created_at ? $expenditure->created_at->format('M d, Y') : 'N/A') }}
                </span>
            </div>
            <div>
                <span class="text-gray-600">Status:</span>
                <span class="font-medium">
                    @if($expenditure->receipt_path)
                        <span class="text-green-600">✓ Has Receipt</span>
                    @else
                        <span class="text-orange-600">⚠ No Receipt</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Current Receipt Display -->
    @if($expenditure->receipt_path)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h3 class="font-medium text-blue-900 mb-3">Current Receipt</h3>
            <div class="flex items-center gap-4">
                @php
                    $extension = strtolower(pathinfo($expenditure->receipt_path, PATHINFO_EXTENSION));
                    $imagePath = $expenditure->receipt_path;
                    if (!str_starts_with($imagePath, 'http') && !str_starts_with($imagePath, '/')) {
                        if (str_starts_with($imagePath, 'storage/')) {
                            $imagePath = asset($imagePath);
                        } else {
                            $imagePath = asset('storage/' . $imagePath);
                        }
                    }
                @endphp
                
                <div class="w-16 h-16 bg-white rounded-lg overflow-hidden border border-blue-300">
                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <img src="{{ $imagePath }}" 
                             alt="Current Receipt" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-blue-600">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a1 1 0 000 2v9a1 1 0 001 1h1a1 1 0 100-2V6a1 1 0 011-1h3a1 1 0 001 1v7a1 1 0 100 2h1a1 1 0 001-1V5a1 1 0 000-2H4z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <div class="flex-1">
                    <div class="text-sm text-blue-800">
                        <div class="font-medium">{{ basename($expenditure->receipt_path) }}</div>
                        <div class="text-blue-600">{{ strtoupper($extension) }} File</div>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <a href="{{ $imagePath }}" 
                       target="_blank" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-colors duration-200">
                        View
                    </a>
                    <a href="{{ $imagePath }}" 
                       download="receipt-{{ $expenditure->id }}.{{ $extension }}"
                       class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-colors duration-200">
                        Download
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Upload Form -->
    <form action="{{ route('admin.expenditure.storeReceipt', $expenditure->id) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="space-y-6">
        @csrf
        
        <div>
            <label class="block font-medium mb-2 text-gray-700" for="receipt">
                @if($expenditure->receipt_path)
                    Replace Receipt File
                @else
                    Receipt File
                @endif
            </label>
            <input type="file" 
                   name="receipt" 
                   id="receipt" 
                   accept="image/*,.pdf"
                   required 
                   class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <p class="text-xs text-gray-500 mt-1">
                Supported formats: JPG, PNG, PDF (Max: 5MB)
            </p>
            @error('receipt')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" 
                    class="flex-1 bg-blue-600 text-white px-4 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200">
                @if($expenditure->receipt_path)
                    Update Receipt
                @else
                    Upload Receipt
                @endif
            </button>
            <a href="{{ route('admin.expenditure.index') }}" 
               class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-3 rounded-lg font-medium transition-colors duration-200 text-center">
                Cancel
            </a>
        </div>
    </form>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 2000,
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

<script>
// File validation
document.getElementById('receipt').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Check file size (5MB limit)
        if (file.size > 5 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File Too Large',
                text: 'Please select a file smaller than 5MB.',
                customClass: {
                    popup: 'rounded-lg'
                }
            });
            e.target.value = '';
            return;
        }
        
        // Check file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
        if (!allowedTypes.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid File Type',
                text: 'Please select a valid image (JPG, PNG) or PDF file.',
                customClass: {
                    popup: 'rounded-lg'
                }
            });
            e.target.value = '';
            return;
        }
    }
});
</script>
@endsection