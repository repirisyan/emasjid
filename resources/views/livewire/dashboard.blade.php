<div wire:init='loadPosts'>
    {{-- In work, do what you enjoy. --}}
    <div class="row">
        <div class="col">
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
    </div>
    <hr>
    <div class="row">
        <div class="col" wire:ignore>
            <canvas id="financeChart"></canvas>
        </div>
        <div class="col" wire:ignore>
            <canvas id="financeChart2"></canvas>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function() {
                console.log(JSON.parse(@this.pemasukkan));
                var pemasukkan = JSON.parse(@this.pemasukkan);
                var saldo_pemasukkan = [];
                var bulan_pemasukkan = [];
                pemasukkan.forEach(element => {
                    saldo_pemasukkan.push(element.saldo);
                    bulan_pemasukkan.push(element.month);
                });

                const ctx = document.getElementById('financeChart');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: bulan_pemasukkan,
                        datasets: [{
                            label: '# Pemasukkan',
                            data: saldo_pemasukkan,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                var pengeluaran = JSON.parse(@this.pengeluaran);
                var total_pengeluaran = [];
                var bulan_pengeluaran = [];
                pengeluaran.forEach(element => {
                    total_pengeluaran.push(element.total_pengeluaran);
                    bulan_pengeluaran.push(element.month);
                });

                const ctx2 = document.getElementById('financeChart2');
                new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: bulan_pengeluaran,
                        datasets: [{
                            label: '# Pengeluaran',
                            data: total_pengeluaran,
                            borderWidth: 1,
                            borderColor: 'rgb(220,20,60)'
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                    }
                });
            });
        </script>
    @endpush
</div>
