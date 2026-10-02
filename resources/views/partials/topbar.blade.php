<div class="bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between sticky top-0 z-30">
    <div>
        <h1 class="text-[15px] font-bold text-gray-800 leading-none">{{ $title }}</h1>
        <p class="text-[11px] text-gray-400 mt-0.5">{{ $subtitle }}</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="flex items-center gap-1.5 bg-gray-50 rounded-full px-3 py-1.5">
            <span>📅</span>
            <span class="text-xs font-medium text-gray-500">{{ now()->locale('id')->isoFormat('dddd, D MMM Y') }}</span>
        </div>
    </div>
</div>