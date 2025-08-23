<form method="GET" class="flex gap-4 mb-4">
    <select name="month" class="border rounded p-2">
        <option value="">-- Month --</option>
        @foreach(range(1,12) as $m)
            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
            </option>
        @endforeach
    </select>

    <select name="year" class="border rounded p-2">
        <option value="">-- Year --</option>
        @for($y = now()->year; $y >= 2020; $y--)
            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endfor
    </select>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
</form>