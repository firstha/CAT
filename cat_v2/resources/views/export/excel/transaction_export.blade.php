<table>
    <thead>
        <tr>
            <th>No</th>
            <th width="25">Nama</th>
            <th width="25">Email</th>
            <th width="20">Provinsi</th>
            <th width="20">Kota/Kab</th>
            <th width="20">Kecamatan</th>
            <th width="20">Desa/Kelurahan</th>
            <th width="60">Alamat</th>
            <th width="20">Nomor Whatsapp</th>
            <th width="20">Kode Transaksi</th>
            <th width="20">Tanggal Transaksi</th>
            <th width="20">Kategori Peminatan</th>
            <th width="20">Kode Voucher</th>
            <th width="25">Nama Voucher</th>
            <th width="15">Period Voucher</th>
            <th width="15">Harga</th>
            <th width="15">Diskon</th>
            <th width="20">Total Pembayaran</th>
            <th width="25">Maksimal Waktu Pembayaran</th>
            <th width="15">Status Transaksi</th>
            <th width="20">Token</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $index => $transaction)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $transaction->user->name }}</td>
                <td>{{ $transaction->user->email }}</td>
                <td>{{ $transaction->user->student->province->name }}</td>
                <td>{{ $transaction->user->student->city->name }}</td>
                <td>{{ $transaction->user->student->district->name }}</td>
                <td>{{ $transaction->user->student->village->name }}</td>
                <td>{{ $transaction->user->student->address }}</td>
                <td>{{ $transaction->user->student->phone_number }}</td>
                <th>{{ $transaction->code }}</th>
                <th>{{ $transaction->date }}</th>
                <th>{{ $transaction->category->name }}</th>
                <th>{{ $transaction->voucher_code }}</th>
                <th>{{ $transaction->voucher_name }}</th>
                <th>{{ $transaction->voucher_active_period }} {{ $transaction->voucher_type }}</th>
                <th>{{ $transaction->voucher_price_before_discount }}</th>
                <th>{{ $transaction->voucher_nominal_discount }}</th>
                <th>{{ $transaction->total_purchases }}</th>
                <th>{{ $transaction->maximum_payment_time }}</th>
                <th>{{ $transaction->transaction_status }}</th>
                <th>{{ $transaction->voucher_token }}</th>
            </tr>
        @endforeach
    </tbody>
</table>