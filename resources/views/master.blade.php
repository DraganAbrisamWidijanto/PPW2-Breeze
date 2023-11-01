<html>
    <head>
        <title>Perpustakaan</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.css">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">
        <script src="{{asset('js/jquery.js')}}">
        <script src="{{asset('js/bootstrap-datepicker.js')}}">
    </head>
    <body>
        <div>
                <label for="tgl_terbit">Tanggal Terbit</label>
                <input type="text" id="tgl_terbit" name="tgl_terbit" class="date" placeholder="yyyy/mm/dd" class="date form-control">
            </div>

        <script type="text/javascript">
            $('.date').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: 'true',
            })
        </script>


        @include('footerr')
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
    </body>
</html>