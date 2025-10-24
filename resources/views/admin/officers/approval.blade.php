@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-xl font-bold mb-4">Officer Approval</h2>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Position</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Resolution</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($officers as $officer)
            <tr>
                <td class="border px-4 py-2">{{ $officer->name }}</td>
                <td class="border px-4 py-2">{{ $officer->position }}</td>
                <td class="border px-4 py-2">
                    <span class="px-2 py-1 rounded text-white
                        {{ $officer->status == 'approved' ? 'bg-green-500' : ($officer->status == 'declined' ? 'bg-red-500' : 'bg-yellow-500') }}">
                        {{ ucfirst($officer->status) }}
                    </span>
                </td>
                <td class="border px-4 py-2">
                    @if($officer->resolution_path)
                        <a href="{{ route('admin.officers.viewResolution', $officer->id) }}" target="_blank"
                           class="text-blue-600 hover:underline">View</a>
                    @else
                        <span class="text-gray-400">No File</span>
                    @endif
                </td>
                <td class="border px-4 py-2 flex gap-2">
                    @if($officer->status == 'pending')
                        <!-- Approve -->
                        <form action="{{ route('admin.officers.approve', $officer->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                Approve
                            </button>
                        </form>

                        <!-- Decline -->
                        <button onclick="declineOfficer({{ $officer->id }})"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                            Decline
                        </button>
                    @endif

                    @if($officer->status == 'declined' && $officer->decline_reason)
                        <span class="text-sm text-red-600">Reason: {{ $officer->decline_reason }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
function declineOfficer(id) {
    Swal.fire({
        title: 'Decline Officer',
        input: 'text',
        inputLabel: 'Reason for declining',
        inputPlaceholder: 'Enter reason...',
        showCancelButton: true,
        confirmButtonText: 'Decline',
        confirmButtonColor: '#e3342f',
        preConfirm: (reason) => {
            if (!reason) {
                Swal.showValidationMessage('Reason is required');
            }
            return reason;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/officers/${id}/decline`;

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            const reasonInput = document.createElement('input');
            reasonInput.type = 'hidden';
            reasonInput.name = 'reason';
            reasonInput.value = result.value;
            form.appendChild(reasonInput);

            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection
