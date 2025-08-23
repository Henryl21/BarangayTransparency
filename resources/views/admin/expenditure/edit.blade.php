@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-2xl mx-auto">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-slate-600 to-slate-700 p-3 rounded-full shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-slate-800 ml-4">Edit Expenditure</h1>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl" role="alert">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <strong>Please correct the following errors:</strong>
                </div>
                <ul class="list-disc list-inside ml-7">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Container -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <form action="{{ route('admin.expenditure.update', $expenditure->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Title Field -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        value="{{ old('title', $expenditure->title) }}"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-gray-800 placeholder-gray-400" 
                        placeholder="Enter expenditure title"
                        required
                    >
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category Field -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Category</label>
                    <div class="relative">
                        <select 
                            name="category" 
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-gray-800 appearance-none cursor-pointer" 
                            required
                        >
                            <option value="" class="text-gray-400">Select Category</option>
                            @foreach (['Infrastructure', 'Education', 'Healthcare', 'Public Safety', 'Utilities', 'Social Services', 'Transportation', 'Environment', 'Administration', 'Other'] as $cat)
                                <option value="{{ $cat }}"
                                    {{ old('category', $expenditure->category) === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount Field -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Amount (₱)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">₱</span>
                        <input 
                            type="number" 
                            name="amount" 
                            value="{{ old('amount', $expenditure->amount) }}"
                            class="w-full pl-8 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-gray-800 placeholder-gray-400" 
                            step="0.01" 
                            min="0"
                            placeholder="0.00"
                            required
                        >
                    </div>
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Field -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Date</label>
                    <div class="relative">
                        <input 
                            type="date" 
                            name="date" 
                            value="{{ old('date', \Carbon\Carbon::parse($expenditure->date)->format('Y-m-d')) }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-gray-800 cursor-pointer"
                            required
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Upload Field -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Upload Receipt/Document</label>
                    
                    <!-- Current Image Display -->
                    @if($expenditure->image)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                            <div class="relative inline-block">
                                <img src="{{ asset('storage/' . $expenditure->image) }}" 
                                     alt="Current expenditure image" 
                                     class="w-32 h-32 object-cover rounded-xl border border-gray-300 shadow-sm">
                                <button type="button" 
                                        onclick="removeCurrentImage()"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors shadow-lg">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <input type="hidden" name="remove_image" id="remove_image" value="0">
                        </div>
                    @endif

                    <!-- File Upload Area -->
                    <div class="relative">
                        <div class="flex items-center justify-center w-full">
                            <label for="receipt-upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-placeholder">
                                    <svg class="w-8 h-8 mb-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG or PDF (MAX. 5MB)</p>
                                </div>
                                <!-- Image Preview -->
                                <div class="hidden w-full h-full relative" id="image-preview">
                                    <img id="preview-image" class="w-full h-full object-cover rounded-xl" alt="Preview" />
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-xl opacity-0 hover:opacity-100 transition-opacity duration-200">
                                        <p class="text-white text-sm font-medium">Click to change image</p>
                                    </div>
                                </div>
                                <input 
                                    id="receipt-upload" 
                                    type="file" 
                                    name="image" 
                                    class="hidden" 
                                    accept="image/*,.pdf"
                                    onchange="handleReceiptUpload(event)"
                                />
                            </label>
                        </div>
                        <!-- File Info -->
                        <div class="mt-2 hidden" id="file-info">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span id="file-name"></span>
                                <span id="file-size" class="ml-2 text-gray-400"></span>
                                <button type="button" onclick="removeFile()" class="ml-auto text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                    <a 
                        href="{{ route('admin.expenditure.index') }}" 
                        class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition-colors duration-200 flex items-center"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Cancel
                    </a>
                    
                    <button 
                        type="submit" 
                        class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        UPDATE EXPENDITURE
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function handleReceiptUpload(event) {
    const file = event.target.files[0];
    const placeholder = document.getElementById('upload-placeholder');
    const preview = document.getElementById('image-preview');
    const previewImage = document.getElementById('preview-image');
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    
    if (file) {
        // Show file info
        fileName.textContent = file.name;
        fileSize.textContent = `(${(file.size / 1024 / 1024).toFixed(2)} MB)`;
        fileInfo.classList.remove('hidden');
        
        // Handle image preview
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                placeholder.classList.add('hidden');
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            // For PDF files, show placeholder with file icon
            placeholder.classList.add('hidden');
            preview.classList.remove('hidden');
            previewImage.src = '';
            preview.innerHTML = `
                <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 rounded-xl">
                    <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-sm text-gray-500 font-medium">PDF Document</p>
                </div>
            `;
        }
    }
}

function removeFile() {
    const input = document.getElementById('receipt-upload');
    const placeholder = document.getElementById('upload-placeholder');
    const preview = document.getElementById('image-preview');
    const fileInfo = document.getElementById('file-info');
    
    input.value = '';
    placeholder.classList.remove('hidden');
    preview.classList.add('hidden');
    fileInfo.classList.add('hidden');
}

function removeCurrentImage() {
    document.getElementById('remove_image').value = '1';
    event.target.closest('.relative').style.display = 'none';
}

// Drag and drop functionality
const uploadArea = document.querySelector('label[for="receipt-upload"]');

if (uploadArea) {
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('border-blue-400', 'bg-blue-50');
    });

    uploadArea.addEventListener('dragleave', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const input = document.getElementById('receipt-upload');
            input.files = files;
            handleReceiptUpload({ target: { files: files } });
        }
    });
}
</script>

<style>
/* Custom styles for date input */
input[type="date"]::-webkit-calendar-picker-indicator {
    opacity: 0;
    cursor: pointer;
}

/* Custom focus styles */
.focus\:ring-2:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Smooth animations */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Hover effects */
.hover\:scale-105:hover {
    transform: scale(1.05);
}

/* Shadow effects */
.shadow-xl {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.hover\:shadow-xl:hover {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Upload area animations */
.border-dashed {
    border-style: dashed;
}

/* File upload hover effects */
label[for="receipt-upload"]:hover {
    border-color: #3b82f6;
}
</style>
@endsection