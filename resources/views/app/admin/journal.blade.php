@extends('app/components/main')
@section('title', 'Pemasukan')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        Jurnal Keuangan
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
                                            <td>{{ $transaction->package->name }}</td>
                                            <td></td>
                                        @else
                                            <td>Pengeluaran</td>
                                            <td></td>
                                            <td>{{ $transaction->item->name }}</td>
                                        @endif
                                        <td>{{ $transaction->quantity }}</td>
                                        <td>Rp. {{ $transaction->getFormattedTotalAttribute() }}</td>
                                        <td>{{ $transaction->getFormattedUpdatedAtAttribute() }}</td>
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
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({

                buttons: ['copy', 'csv', 'print', 'excel', 'pdf', 'colvis'],
                dom: "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "All"]
                ],

                fixedColumns: true,

                language: {

                    "search": "Cari:",

                    "lengthMenu": "Tampilkan _MENU_ baris",

                    "zeroRecords": "Data tidak ditemukan",

                    "info": "Halaman _PAGE_ dari _PAGES_",

                    "infoEmpty": "Tidak ada data",

                    "infoFiltered": "(pencarian dari _MAX_ data)",

                    "buttons": {
                        "colvis": "Kolom"
                    }

                },

                responsive: true,

                stateSave: true, // keep paging

                scrollX: true
            });

            table.buttons().container()
                .appendTo('#dataTable_wrapper .col-md-5:eq(0)');
        });
    </script>
@endsection
