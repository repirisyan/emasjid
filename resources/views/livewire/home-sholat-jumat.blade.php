<div wire:init="loadPosts">
    {{-- The Master doesn't talk, he acts. --}}
    <div class="card mt-5">
        <div class="card-body">
            <div class="table table-responsive-sm">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <tr>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Imam</th>
                            <th scope="col">Khotib</th>
                        </tr>
                    </thead>
                    <tbody wire:init="loadPosts">
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->imam->name }}</td>
                                <td>{{ $item->khotib->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($readyToLoad == true)
                <div>
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
