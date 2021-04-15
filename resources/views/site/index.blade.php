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
            <input type="file" name="file" id="file" accept="image/png,image/jpg,image/jpeg" >
        </label>
    </form>
    <button class="button" onclick="sendData()">Wyślij</button>
    <div id="message" class="whiteText"></div>
</div>
<script>

    var url =  '{{ route("formdata.store") }}';

    function sendData(){
        var fileField = document.querySelector('#file').value;

        if(fileField.files){

            const formData = new FormData();
            formData.append('file', fileField.files[0]);

        } else{
            formData =  null;
        }


        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


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
                    file    : formData

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
