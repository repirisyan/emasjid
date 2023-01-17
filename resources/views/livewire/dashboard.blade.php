<div wire:init='loadPosts'>
    {{-- In work, do what you enjoy. --}}
    <x-adminlte-alert theme="primary" title="Primary Notification" class="d-inline-block">
        Selamat datang di E-masjid <b>{{ auth()->user()->name }}</b>
    </x-adminlte-alert>
    <x-adminlte-alert theme="info" title="Total Saldo Masjid" class="d-inline-block">
        @if ($this->readyToLoad == false)
            <div class="text-center">
                <i class="fa fa-fw fa-spinner fa-spin"></i>
            </div>
        @else
            Rp. {{ number_format($saldo, '0', ',', '.') }}
        @endif
    </x-adminlte-alert>
</div>
