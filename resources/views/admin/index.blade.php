<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table>
                        <thead>
                            <tr>
                               <th>Imię</th> <th>Nazwisko</th> <th>Plik</th>
                            </tr>
                         </thead>
                         <tbody>
                            @foreach ( $formData as $data )
                                <tr>
                                    <td> {{$data->name    ?? ""}} </td>
                                    <td> {{$data->surname ?? ""}} </td>
                                    <td> @if($data->link != null)  <a target="_blank" href="{{ asset('images') . '/'. $data->link }}">link do pliku</a> @endif </td>
                                </tr>
                            @endforeach
                         </tbody>
                     </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
