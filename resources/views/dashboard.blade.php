@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h5>Learning Activities</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead style="border: 1px solid black">
                            <tr style="border: 1px solid black">
                                <th scope="col" style="border: 1px solid black">Metode</th>
                                @foreach ($bulans as $bulan)
                                    <th scope="col" style="border: 1px solid black">{{ $bulan->bulan }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody style="border: 1px solid black">
                            @foreach ($metodes as $metode)
                                <tr style="border: 1px solid black">
                                    <td style="border: 1px solid black">{{ $metode->metode }}</td>
                                    @foreach ($bulans as $bulan)
                                        <td style="border: 1px solid black">
                                            @if (isset($activityByMetodeAndBulan[$metode->id][$bulan->id]))
                                                {{ $activityByMetodeAndBulan[$metode->id][$bulan->id] }}                                        
                                            @else
                                                
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>


<script>
    $('body').on('click', '#button_tambah_activity', function(){
        $('#modal_tambah_activity').modal('show');
        clearAlert();
    });
</script>

@endsection