<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expenditure Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { height: 80px; }
        .header h1 { margin: 8px 0 0; font-size: 22px; }
        .header p { margin: 2px 0; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 8px; font-size: 14px; }
        th { background: #f1f1f1; }
        .category-row { background: #f9f9f9; font-weight: bold; }
        .totals { margin-top: 30px; font-size: 16px; font-weight: bold; text-align: right; }
        .signature { margin-top: 80px; display: flex; justify-content: space-between; }
        .signature div { text-align: center; }
    </style>
</head>
<body>

   <!-- Header -->
<div class="header">
    @if($settings && $settings->logo)
        <img src="{{ asset('storage/'.$settings->logo) }}" alt="Barangay Logo">
    @else
        <div style="width:80px; height:80px; background:#ccc; display:inline-block;"></div>
    @endif

    <h1>{{ $settings->barangay_name ?? 'Barangay eBudget Transparency System' }}</h1>

   
    <p>{{ now()->format('F d, Y') }}</p>
</div>


    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Title</th>
                <th>Amount (₱)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @php $count = 1; $currentCategory = null; @endphp
            @foreach($expenditures as $exp)
                @if($currentCategory !== $exp->category)
                    <tr class="category-row">
                        <td colspan="6">{{ $exp->category }}</td>
                    </tr>
                    @php $currentCategory = $exp->category; @endphp
                @endif
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $exp->category }}</td>
                    <td>{{ $exp->title }}</td>
                    <td>₱{{ number_format($exp->amount, 2) }}</td>
                    <td>{{ $exp->date ? \Carbon\Carbon::parse($exp->date)->format('M d, Y') : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals">
        Total Spent: ₱{{ number_format($totalSpent, 2) }}
    </div>

    <!-- Signatures -->
    <div class="signature">
        <div>
            ___________________________<br>
            Prepared By
        </div>
        <div>
            ___________________________<br>
            Barangay Captain
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();

            // When print dialog is closed (cancel or done), go back
            window.onafterprint = function() {
                // Redirect to the expenditures section on same page
                window.location.href = "{{ url()->previous() }}#expenditures";
            };
        };
    </script>

</body>
</html>
