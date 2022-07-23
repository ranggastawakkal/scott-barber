@extends('app/components/main')
@section('title', 'Jurnal Keuangan')

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
                                        <td>{{ $transaction->getFormattedCreatedAtAttribute() }}</td>
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

    {{-- modal edit data --}}
    @foreach ($transactions as $transaction)
    <div class="modal fade" id="modalUbahData{{ $transaction->id }}" tabindex="-1" aria-labelledby="modalUbahDataLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUbahDataLabel">Ubah {{ $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('transactions.update',$transaction->id) }}">
                        @csrf
                        <div id="add_form_pengeluaran">
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    @if ($transaction->type == 'income')
                                    <select class="form-control" name="package_id" id="packageIncome{{ $transaction->id }}"" required>
                                        <option value="" selected disabled>--- Paket Jasa ---</option>
                                        <option value="{{ $transaction->package_id }}" selected hidden>{{ $transaction->package->name }}</option>
                                        @foreach ($packages as $package)
                                            <option value="{{ $package->id }}">{{ $package->name }}</option>
                                        @endforeach
                                    </select>
                                    @else    
                                        <select class="form-control" name="item_id" required>
                                            <option value="" selected disabled>--- Barang ---</option>
                                            <option value="{{ $transaction->item_id }}" selected hidden>{{ $transaction->item->name }}</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="quantity" id="{{ $transaction->type == 'income' ? 'quantityIncome'.$transaction->id : 'quantity' }}"
                                        placeholder="Jumlah" value="{{ $transaction->quantity }}" min="1" required>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-weight-bold" id="basic-addon1">Rp.</span>
                                        </div>
                                        <input type="number" class="form-control bg-white" aria-describedby="basic-addon1"
                                            id="{{ $transaction->type == 'income' ? 'subtotalIncome'.$transaction->id : 'subtotal' }}" name="total" value="{{ $transaction->total }}"
                                            placeholder="Sub Total" required {{ $transaction->type == 'income' ? 'readonly' : '' }}>
                                    </div>
                                </div>
                            </div>
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
    {{-- end of modal edit data --}}
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({

                buttons: [
                    {
                        extend:'csv',
                        text:'CSV',
                        className:'btn btn-success',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    }, 
                    {
                        extend:'print',
                        text:'Print',
                        className:'btn btn-success',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend:'excel',
                        text:'Excel',
                        className:'btn btn-success',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend:'pdf',
                        text:'PDF',
                        className:'btn btn-success',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend:'colvis',
                        text:'Kolom',
                        className:'btn btn-success',
                    },
                ],
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

            @foreach ($transactions as $transaction)
            $('#packageIncome{{ $transaction->id }}').on('change',function(e){
                e.preventDefault();
                var id = $(this).val();
                $.ajax({
                    url: '/daily-transactions/get-package-price/' + id,
                    method: 'GET',
                    success: function(response){
                        var quantity = $('#quantityIncome{{ $transaction->id }}');
                        var subtotal = $('#subtotalIncome{{ $transaction->id }}');
                        var subtotalVal = quantity.val() * response.replace(".", "");

                        subtotal.val(subtotalVal);
                        
                        quantity.on('change',function(){
                            subtotal.val(quantity.val() * response.replace(".", ""));
                        });
                    }
                });
            });
            @endforeach

            @foreach ($transactions as $transaction)
            $('#quantityIncome{{ $transaction->id }}').on('change',function(e){
                e.preventDefault();
                var id = $('#packageIncome{{ $transaction->id }}').val();
                $.ajax({
                    url: '/daily-transactions/get-package-price/' + id,
                    method: 'GET',
                    success: function(response){
                        var package = $('#packageIncome{{ $transaction->id }}');
                        var quantity = $('#quantityIncome{{ $transaction->id }}');
                        var subtotal = $('#subtotalIncome{{ $transaction->id }}');
                        var subtotalVal = quantity.val() * response.replace(".", "");

                        subtotal.val(subtotalVal);

                        package.on('change',function(){
                            subtotal.val(quantity.val() * response.replace(".", ""));
                        });
                    }
                });
            })
            @endforeach
        });
    </script>
@endsection
