@props(['get'])

@php
    use App\Models\DamageReport;

    $reportId = $get('damage_report_id');
    $report = DamageReport::find($reportId);
@endphp

@if ($report && $report->attachment)
    <div class="flex justify-center">
        <img src="{{ asset('storage/' . $report->attachment) }}" alt="Attachment" class="w-64 rounded-xl shadow">
    </div>
@else
    <div class="text-center text-sm text-gray-500 italic">
        No attachment available.
    </div>
@endif
