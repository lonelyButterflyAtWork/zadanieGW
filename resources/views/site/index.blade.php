@extends('layouts.header')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" id="csrf-token" />
@endsection
@section('content')
<div class="whiteText">
    <form action="{{ route("formdata.store") }}" method="post">
        @csrf
        <label>
            <p>Imię</p>
            <input type="text" name="name" id="name" required>
        </label>
        <label>
            <p>Nazwisko</p>
            <input type="text" name="surname" id="surname">
        </label>
        <label>
            <p>Plik</p>
            <input type="file"  name="file" id="file" accept="image/png,image/jpg,image/jpeg">
            <input type="hidden" name="file2" id="hiddenFile">

        </label>
    </form>
    <button class="button" onclick="sendData()">Wyślij</button>
    <div id="message" class="whiteText"></div>
</div>
<script>

    var url =  '{{ route("formdata.store") }}';

    function loadCanvasWithInputFile(){
        var fileinput = document.getElementById('file');
        fileinput.onchange = function(evt) {
            var files = evt.target.files;
            var file = files[0];
            if(file.type.match('image.*')) {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(evt){
                    if( evt.target.readyState == FileReader.DONE) {
                        document.querySelector('#hiddenFile').value = evt.target.result;
                    }
                }

            } else {
                alert("not an image");
            }
        };
    }
    loadCanvasWithInputFile();
    function sendData(){
        var formData;
        var fileField = document.querySelector('#file');
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        console.log(file);


        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type'    : 'application/json',
                "Accept"          : "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                'X-CSRF-TOKEN'    : token
        },
                body: JSON.stringify({
                    name    : document.querySelector('#name').value,
                    surname : document.querySelector('#surname').value,
                    file    : document.querySelector('#hiddenFile').value

                })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            document.querySelector('#message').innerHTML = (data.success) ? "zapisano" : data.err;

        });

    }
</script>
@endsection
