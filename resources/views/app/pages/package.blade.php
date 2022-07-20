@extends('app/components/main')
@section('title', 'Paket Jasa')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center">
                    <h6 class="m-0 font-weight-bold text-dark">
                        Paket Jasa
                    </h6>
                </div>
                @if ($errors->count() > 0)
                    <div id="ERROR_COPY" style="display: none;">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br />
                        @endforeach
                    </div>
                @endif
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
                                    <th>Nama Paket</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($packages as $package)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $package->name }}</td>
                                        <td>Rp. {{ $package->getFormattedPriceAttribute() }}</td>
                                        <td scope="row" class="text-center">
                                            <a href="" data-bs-toggle="modal"
                                                data-bs-target="#modalUbahData{{ $package->id }}"
                                                class="btn btn-sm btn-dark">Ubah</a>
                                            <a href="{{ route('package.destroy', $package->id) }}"
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
                    <h5 class="modal-title" id="modalTambahDataLabel">Tambah Paket Jasa</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('package.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="col-form-label font-weight-bold">Nama Paket
                                Jasa</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}" required>
                        </div>
                        <label for="price" class="col-form-label font-weight-bold">Harga</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="basic-addon1">Rp.</span>
                            </div>
                            <input type="number" class="form-control" aria-describedby="basic-addon1" id="price"
                                name="price" onkeypress="price()" value="{{ old('price') }}" required>
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

    {{-- modal ubah data --}}
    @foreach ($packages as $package)
        <div class="modal fade" id="modalUbahData{{ $package->id }}" tabindex="-1" aria-labelledby="modalUbahDataLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUbahDataLabel">Ubah Paket Jasa</h5>
                        <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('package.update', $package->id) }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $package->id }}">
                            <div class="mb-3">
                                <label for="name" class="col-form-label font-weight-bold">Nama Paket
                                    Jasa</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $package->name }}" required>
                            </div>
                            <label for="price" class="col-form-label font-weight-bold">Harga</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="basic-addon1">Rp.</span>
                                </div>
                                <input type="number" class="form-control" aria-describedby="basic-addon1"
                                    id="price" name="price" value="{{ $package->price }}" required>
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
    {{-- end of modal ubah data --}}
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

            $('.btn-delete').on('click', function(event) {
                event.preventDefault();
                const url = $(this).attr('href');
                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Data akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                })
            });
        });


        // validation error
        var has_errors = document.querySelector('#ERROR_COPY');

        if (has_errors !== null) {
            Swal.fire({
                title: 'Gagal',
                icon: 'error',
                html: jQuery('#ERROR_COPY').html(),
                showCloseButton: true
            })
        }
        // end of validation error
    </script>
@endsection
