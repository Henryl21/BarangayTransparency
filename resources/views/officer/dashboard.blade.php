@extends('layouts.app') {{-- Or use a dedicated officer layout if you have one --}}

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div class="bg-white shadow-md rounded-xl p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Officer Dashboard</h1>
            <p class="text-gray-500">
                Welcome, {{ Auth::guard('officer')->user()->name }}
            </p>
        </div>

        <!-- Approval Form -->
        <div class="bg-white shadow-md rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-4">Send Expenditure Request</h2>

            <form action="{{ route('officer.expenditures.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <input type="hidden" name="type" value="expense">

                <div>
                    <label class="block text-gray-700 font-medium">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300"
                        required>
                    @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Amount</label>
                    <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300"
                        required>
                    @error('amount') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Receipt (optional)</label>
                    <input type="file" name="receipt"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                    @error('receipt') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Resolution Upload -->
                <div>
                    <label class="block text-gray-700 font-medium">Resolution Document (Word/PDF)</label>
                    <input type="file" name="resolution" accept=".doc,.docx,.pdf"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                    @error('resolution') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    Submit for Approval
                </button>
            </form>
        </div>

        <!-- Past Requests -->
        <div class="bg-white shadow-md rounded-xl p-6 mt-6">
            <h2 class="text-xl font-semibold mb-4">My Requests</h2>

            <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Title</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Resolution</th>
                        <th class="px-4 py-2">Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenditures as $exp)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $exp->title }}</td>
                            <td class="px-4 py-2">₱{{ number_format($exp->amount, 2) }}</td>
                            <td class="px-4 py-2">
                                @if($exp->status === 'approved')
                                    <span class="text-green-600 font-semibold">Approved</span>
                                @elseif($exp->status === 'declined')
                                    <span class="text-red-600 font-semibold">Declined</span>
                                @else
                                    <span class="text-yellow-600 font-semibold">Pending</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($exp->resolution)
                                    <a href="{{ Storage::url($exp->resolution) }}" target="_blank" class="text-blue-600 underline">View</a>
                                @else
                                    <span class="text-gray-400">None</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $exp->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                                No requests yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
