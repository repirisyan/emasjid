<div>
    {{-- In work, do what you enjoy. --}}
    <x-adminlte-alert theme="primary" title="Primary Notification" class="d-inline-block">
        Selamat datang di E-masjid <b>{{ auth()->user()->name }}</b>
    </x-adminlte-alert>
    <x-adminlte-alert theme="info" title="Total Saldo Masjid" class="d-inline-block">
        Rp. {{ $saldo }}
    </x-adminlte-alert>
</div>
