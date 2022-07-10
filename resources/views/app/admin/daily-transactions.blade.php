@extends('app/components/main')
@section('title', 'Transaksi Hari Ini')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center">
                    <h6 class="m-0 font-weight-bold text-dark">
                        Transaksi Hari Ini
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
                    <div class="row justify-content-around mb-3">
                        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal"
                            data-bs-target="#modalTambahData">
                            <i class="fas fa-plus"></i> Tambah Pemasukan
                        </button>
                        <button type="button" class="btn btn-danger mb-3" data-bs-toggle="modal"
                            data-bs-target="#modalTambahData">
                            <i class="fas fa-plus"></i> Tambah Pengeluaran
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover display nowrap" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-center">
                                <tr>
                                    <th>No.</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Kode Transaksi</th>
                                    <th>Tipe</th>
                                    <th>Paket Jasa</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Nominal</th>
                                    <th>Bayar</th>
                                    <th>Kembali</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $transaction->user->name }}</td>
                                        <td>{{ $transaction->transaction_code }}</td>
                                        @if ($transaction->type == 'income')
                                            <td>Pemasukan</td>
                                            <td>{{ $transaction->income->package->name }}</td>
                                            <td></td>
                                            <td>{{ $transaction->income->quantity }}</td>
                                        @else
                                            <td>Pengeluaran</td>
                                            <td></td>
                                            <td>{{ $transaction->expense->item->name }}</td>
                                            <td>{{ $transaction->expense->quantity }}</td>
                                        @endif
                                        <td>{{ $transaction->amount }}</td>
                                        <td>{{ $transaction->pay }}</td>
                                        <td>{{ $transaction->charge }}</td>
                                        <td>{{ $transaction->updated_at }}</td>
                                        <td scope="row" class="text-center">
                                            <a href="" data-bs-toggle="modal"
                                                data-bs-target="#modalUbahData{{ $transaction->id }}"
                                                class="btn btn-sm btn-dark">Ubah</a>
                                            <a href="{{ route('daily-transactions.destroy', $transaction->id) }}"
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
