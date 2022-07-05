@extends('app/components/main')
@section('title', 'Karyawan')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center">
                    <h6 class="m-0 font-weight-bold text-dark">
                        Karyawan
                    </h6>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalTambahData">
                        <i class="fas fa-plus"></i> Tambah Data
                    </button>
                    <div class="table-responsive">
                        <table class="table table-hover display nowrap" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-center">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Karyawan</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->stock }}</td>
                                        <td scope="row" class="text-center">
                                            <a href="" data-bs-toggle="modal"
                                                data-bs-target="#modalUbahData{{ $item->id }}"
                                                class="btn btn-sm btn-dark">Ubah</a>
                                            <a href="{{ route('item.destroy', $item->id) }}"
                                                class="btn btn-sm btn-danger btn-delete">Hapus</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal add data --}}
    <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDataLabel">Tambah Karyawan</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('item.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="col-form-label font-weight-bold">Nama Karyawan</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="col-form-label font-weight-bold">Stok</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal add data --}}

    {{-- modal editUbahdata --}}
    @foreach ($items as $item)
        <div class="modal fade" id="modalUbahData{{ $item->id }}" tabindex="-1" aria-labelledby="modalUbahDataLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUbahDataLabel">Ubah Karyawan</h5>
                        <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('item.update', $item->id) }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <div class="mb-3">
                                <label for="name" class="col-form-label font-weight-bold">Nama Paket
                                    Jasa</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $item->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="col-form-label font-weight-bold">Stok</label>
                                <input type="number" class="form-control" id="stock" name="stock"
                                    value="{{ $item->stock }}" required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    {{-- end of modal editUbahdata --}}
@endsection

@section('javascript')
    <script type="text/javascript">
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "All"]
                ],
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data",
                    "infoFiltered": "(pencarian dari _MAX_ data)",
                },
                responsive: true,
                stateSave: true, // keep paging
                "scrollX": true
            });
        });

        $('.btn-delete').on('click', function(event) {
            event.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: 'Anda yakin?',
                text: 'Data ini akan dihapus permanen!',
                icon: 'warning',
                buttons: ["Batal", "Hapus"],
            }).then(function(value) {
                if (value) {
                    window.location.href = url;
                }
            });
        });
    </script>
@endsection
