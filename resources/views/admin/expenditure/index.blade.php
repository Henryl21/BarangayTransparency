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
            
            <!-- Print Button -->
            <button onclick="printExpenditures()" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                PRINT REPORT
            </button>
        </div>
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
                        {{ $exp->category == 'Infrastructure' ? 'bg-blue-100 text-blue-800' :
                           ($exp->category == 'Education' ? 'bg-green-100 text-green-800' :
                           ($exp->category == 'Healthcare' ? 'bg-red-100 text-red-800' :
                           ($exp->category == 'Public Safety' ? 'bg-yellow-100 text-yellow-800' :
                           ($exp->category == 'Utilities' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800')))) }}">
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
    @if($exp->hasReceipt())
        @php
            $receiptUrl = $exp->receipt_url ?? asset('storage/' . ($exp->receipt ?? $exp->receipt_path));
            $isImage = $exp->isReceiptImage();
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
                <button onclick="openFullReceipt()" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                    Full View
                </button>
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

<!-- Print Styles -->
<style>
@media print {
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body * {
        visibility: hidden;
    }
    
    .print-content, .print-content * {
        visibility: visible;
    }
    
    .print-content {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        background: white !important;
        color: black !important;
        font-family: Arial, sans-serif;
        font-size: 12px;
        line-height: 1.4;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    .print-header {
        text-align: center;
        border-bottom: 2px solid #000;
        padding-bottom: 20px;
        margin-bottom: 20px;
        page-break-inside: avoid;
    }
    
    .print-title {
        font-size: 22px;
        font-weight: bold;
        color: #000 !important;
        margin-bottom: 8px;
    }
    
    .print-subtitle {
        font-size: 14px;
        color: #000 !important;
        margin-bottom: 4px;
    }
    
    .print-total {
        font-size: 16px;
        font-weight: bold;
        color: #000 !important;
        background-color: #f0f0f0 !important;
        padding: 15px;
        margin: 15px 0;
        border: 2px solid #000;
        text-align: center;
        page-break-inside: avoid;
    }
    
    .print-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        page-break-inside: auto;
    }
    
    .print-table th {
        background-color: #e0e0e0 !important;
        border: 1px solid #000 !important;
        padding: 10px 6px;
        text-align: left;
        font-weight: bold;
        font-size: 11px;
        color: #000 !important;
        page-break-inside: avoid;
    }
    
    .print-table td {
        border: 1px solid #000 !important;
        padding: 8px 6px;
        font-size: 10px;
        vertical-align: top;
        color: #000 !important;
    }
    
    .print-table tbody tr:nth-child(even) {
        background-color: #f5f5f5 !important;
    }
    
    .print-amount {
        text-align: right;
        font-weight: bold;
    }
    
    .print-category {
        font-size: 9px;
        padding: 2px 4px;
        background-color: #ddd !important;
        color: #000 !important;
        border: 1px solid #999;
        border-radius: 3px;
        display: inline-block;
    }
    
    .print-footer {
        margin-top: 30px;
        border-top: 1px solid #000;
        padding-top: 15px;
        font-size: 10px;
        color: #000 !important;
        page-break-inside: avoid;
    }
    
    .print-signature {
        margin-top: 40px;
        display: table;
        width: 100%;
        table-layout: fixed;
    }
    
    .signature-block {
        display: table-cell;
        text-align: center;
        width: 33.33%;
        padding: 0 10px;
    }
    
    .signature-line {
        border-top: 1px solid #000;
        margin-top: 30px;
        padding-top: 5px;
        font-size: 10px;
        color: #000 !important;
    }
}

.print-content {
    display: none;
}
</style>

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

// Print Function
function printExpenditures() {
    // Check if there are expenditures to print
    const expenditureRows = document.querySelectorAll('#expenditure-table-body > div');
    let hasData = false;
    
    expenditureRows.forEach((row) => {
        const cells = row.querySelectorAll('div[class*="col-span"]');
        if (cells.length >= 6) {
            const title = cells[1].textContent.trim();
            if (title && !title.includes('No expenditures found')) {
                hasData = true;
            }
        }
    });
    
    if (!hasData) {
        Swal.fire({
            icon: 'warning',
            title: 'No Data to Print',
            text: 'There are no expenditure records to print.',
            customClass: {
                popup: 'rounded-lg'
            }
        });
        return;
    }

    // Show loading
    Swal.fire({
        title: 'Preparing Report...',
        text: 'Please wait while we prepare your expenditure report.',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });

    // Create print content
    const printContent = createPrintContent();
    
    // Remove any existing print content
    let printArea = document.getElementById('print-content');
    if (printArea) {
        printArea.remove();
    }
    
    // Create new print area
    printArea = document.createElement('div');
    printArea.id = 'print-content';
    printArea.className = 'print-content';
    printArea.innerHTML = printContent;
    
    // Add to body
    document.body.appendChild(printArea);
    
    // Close loading and print
    setTimeout(() => {
        Swal.close();
        
        // Show the print content before printing
        printArea.style.display = 'block';
        
        // Trigger print
        window.print();
        
        // Hide print content after printing
        setTimeout(() => {
            if (printArea) {
                printArea.style.display = 'none';
            }
        }, 500);
    }, 1000);
}

function createPrintContent() {
    const currentDate = new Date().toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    let tableRows = '';
    let totalAmount = 0;
    let recordCount = 0;

    // Get all expenditure rows
    const expenditureRows = document.querySelectorAll('#expenditure-table-body > div');
    
    expenditureRows.forEach((row, index) => {
        const cells = row.querySelectorAll('div[class*="col-span"]');
        
        if (cells.length >= 6) {
            const id = cells[0].textContent.trim();
            const title = cells[1].textContent.trim();
            const category = cells[2].textContent.trim();
            const amount = cells[3].textContent.trim();
            const date = cells[4].textContent.trim();
            const receiptCell = cells[5].textContent.trim();
            
            // Skip if this is the "no data" row
            if (id === '' || title.includes('No expenditures found') || !title || title === 'N/A') {
                return;
            }
            
            // Extract numeric value from amount
            const numericAmount = parseFloat(amount.replace('₱', '').replace(/,/g, ''));
            if (!isNaN(numericAmount)) {
                totalAmount += numericAmount;
            }
            
            recordCount++;
            
            // Clean up category text (remove extra spaces from badge)
            const cleanCategory = category.replace(/\s+/g, ' ').trim();
            const hasReceipt = receiptCell && !receiptCell.includes('No Receipt');
            
            tableRows += `
                <tr>
                    <td style="text-align: center; font-weight: bold;">${id}</td>
                    <td>${title}</td>
                    <td>
                        <span class="print-category">${cleanCategory}</span>
                    </td>
                    <td class="print-amount">${amount}</td>
                    <td style="text-align: center;">${date}</td>
                    <td style="text-align: center; font-weight: bold;">${hasReceipt ? '✓' : '✗'}</td>
                </tr>
            `;
        }
    });

    // If no records found, add a "no data" row
    if (recordCount === 0) {
        tableRows = `
            <tr>
                <td colspan="6" style="text-align: center; font-style: italic; color: #666; padding: 30px;">
                    No expenditure records found
                </td>
            </tr>
        `;
        totalAmount = 0;
    }

    return `
        <div style="padding: 20px; max-width: 100%; margin: 0 auto;">
            <div class="print-header">
                <div class="print-title">EXPENDITURE REPORT</div>
                <div class="print-subtitle">Barangay Budget Management System</div>
                <div class="print-subtitle">Report Date: ${currentDate}</div>
            </div>

            <div class="print-total">
                Total Expenditures: ₱${totalAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}
                <br>
                <span style="font-size: 12px; font-weight: normal;">Total Records: ${recordCount}</span>
            </div>

            <table class="print-table">
                <thead>
                    <tr>
                        <th style="width: 8%;">ID</th>
                        <th style="width: 32%;">Title</th>
                        <th style="width: 15%;">Category</th>
                        <th style="width: 15%;">Amount</th>
                        <th style="width: 15%;">Date</th>
                        <th style="width: 10%;">Receipt</th>
                    </tr>
                </thead>
                <tbody>
                    ${tableRows}
                </tbody>
            </table>

            <div class="print-footer">
                <p><strong>Report Summary:</strong></p>
                <p>This report contains ${recordCount} expenditure record(s) with a total amount of ₱${totalAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}.</p>
                <p>Generated by: Barangay Budget Management System</p>
                
                <div class="print-signature">
                    <div class="signature-block">
                        <div class="signature-line">Prepared By</div>
                    </div>
                    <div class="signature-block">
                        <div class="signature-line">Reviewed By</div>
                    </div>
                    <div class="signature-block">
                        <div class="signature-line">Approved By</div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Close modal when clicking outside of it
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('receiptModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeReceiptModal();
            }
        });
    }
    
    // Highlight new expenditure
    @if(session('new_expenditure_id'))
        setTimeout(() => {
            const element = document.querySelector('[data-expenditure-id="{{ session('new_expenditure_id') }}"]');
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }, 500);
    @endif
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeReceiptModal();
    }
});
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