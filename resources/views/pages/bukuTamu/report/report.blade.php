<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>ID Registrasi</th>
                <th>Nama</th>
                <th>Jenis Jasa</th>
                <th>No Plat</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Tujuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bukuTamu as $index => $i)
            <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td>{{ $i->id_registrasi }}</td>
                <td>{{ $i->nama }}</td>
                <td>{{ $i->jenis_paket == 1 ? 'Grab' : 'Gojek' }}</td>
                <td>{{ $i->no_plat }}</td>
                <td>{{ $i->tanggal->isoFormat('D MMMM Y') }}</td>
                <td>{{ $i->jam }}</td>
                <th>{{ $i->tujuan == 1 ? 'Mengambil' : 'Mengirim' }}</th>
                <td>{{ $i->status == 1 ? 'Sudah Diambil' : 'Belum Diambil' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>