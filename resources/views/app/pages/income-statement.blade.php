@extends('app/components/main')
@section('title', 'Laba / Rugi')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        Laba / Rugi
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
                    <div class="row justify-content-center">

                        <table class="mb-2" border="0" cellspacing="5" cellpadding="5">
                            <tbody>
                                <tr>
                                    <td>
                                        <input class="form-control form-control-sm" type="text" id="min" name="min" placeholder="Tanggal awal" required>
                                    </td>
                                    <td>s/d</td>
                                    <td>
                                        <input class="form-control form-control-sm" type="text" id="max" name="max" placeholder="Tanggal akhir" required>
                                    </td>
                                    <td>
                                        <button class="btn btn-success" id="search_date_range">Cari</button>
                                    </td>
                                    <td>
                                        <button type="reset" class="btn btn-warning" id="reset_date_range">Reset</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless display nowrap" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr style="display: none;">
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th class="text-right">Periode :</th>
                                <th><span class="from_date">{{ $from_date->created_at->format('d M Y') }}</span> - <span class="to_date">{{ $to_date->created_at->format('d M Y') }}</span></th>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Pendapatan Usaha</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>Pendapatan Penjualan Usaha</td>
                                <td class="income_total">Rp. {{ $formatted_income_total }}</td>
                            </tr>
                            <tr>
                                <th>Total Pendapatan</th>
                                <th class="income_total">Rp. {{ $formatted_income_total }}</th>
                            </tr>
                            <tr>
                                <th>Beban Usaha</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>Pengeluaran</td>
                                <td class="expense_total">Rp. {{ $formatted_expense_total }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Laba / Rugi Bersih</th>
                                <th class="cash_total">Rp. {{ $formatted_cash_total }}</th>
                            </tr>
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
        // var minDate, maxDate;
 

        $(document).ready(function() {
            // Create date inputs
            minDate = new DateTime($('#min'), {
                // format: 'D-MM-YYYY hh:mm:ss'
                format: 'YYYY-MM-DD'
                // format: 'MMMM Do YYYY'
            });
            maxDate = new DateTime($('#max'), {
                // format: 'D-MM-YYYY hh:mm:ss'
                format: 'YYYY-MM-DD'
                // format: 'MMMM Do YYYY'
            });

            var table = $('#dataTable').DataTable({

                buttons: [
                    {
                        extend:'csv',
                        text:'CSV',
                        className:'btn btn-success',
                        exportOptions: {
                            columns: 'th:not(.notexport)'
                        },
                        footer: true
                    }, 
                    {
                        extend:'print',
                        text:'Print',
                        className:'btn btn-success',
                        exportOptions: {
                            columns: 'th:not(.notexport)'
                        },
                        footer: true
                    },
                    {
                        extend:'excel',
                        text:'Excel',
                        className:'btn btn-success',
                        exportOptions: {
                            columns: 'th:not(.notexport)'
                        },
                        footer: true
                    },
                    {
                        extend:'pdf',
                        text:'PDF',
                        className:'btn btn-success',
                        exportOptions: {
                            columns: 'th:not(.notexport)'
                        },
                        footer: true
                    },
                    // {
                    //     extend:'colvis',
                    //     text:'Kolom',
                    //     className:'btn btn-success',
                    // },
                ],
                dom: "<'row justify-content-center'<'col-md-3'B>>" +
                    "<'row'<'col-md-12'tr>>",
                ordering: false,
            });

            // Refilter the table
            $('#search_date_range').on('click', function (e) {
                e.preventDefault();
                var minDate = $('#min').val();
                var maxDate = $('#max').val();
                $.ajax({
                    url: '/journal/get-income-statement-value/'+ minDate + '/' + maxDate,
                    method: 'GET',
                    success: function(response){
                        var incomeTotal = $('.income_total');
                        var expenseTotal = $('.expense_total');
                        var cashTotal = $('.cash_total');
                        var fromDate = $('.from_date');
                        var toDate = $('.to_date');

                        incomeTotal.text(response.formatted_income_total);
                        expenseTotal.text(response.formatted_expense_total);
                        cashTotal.text(response.formatted_cash_total);
                        fromDate.text(response.from_date);
                        toDate.text(response.to_date);
                    }
                });
                table.draw();
            });
            
            $('#reset_date_range').on('click', function () {
                $('#min').val('');
                $('#max').val('');
                $('.income_total').text('Rp. {{ $formatted_income_total }}');
                $('.expense_total').text('Rp. {{ $formatted_expense_total }}');
                $('.cash_total').text('Rp. {{ $formatted_cash_total }}');
                $('.from_date').text('{{ $from_date->created_at->format('d M Y') }}');
                $('.to_date').text('{{ $to_date->created_at->format('d M Y') }}');
                table.draw();
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
        });
    </script>
@endsection
