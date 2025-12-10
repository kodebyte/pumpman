@props(['active' => false, 'trueText' => 'Active', 'falseText' => 'Inactive'])

@if($active)
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
        <span class="w-1.5 h-1.5 mr-1.5 bg-emerald-500 rounded-full"></span>
        {{ $trueText }}
    </span>
@else
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
        <span class="w-1.5 h-1.5 mr-1.5 bg-slate-400 rounded-full"></span>
        {{ $falseText }}
    </span>
@endif