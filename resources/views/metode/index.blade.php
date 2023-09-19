@extends('layouts.main')

@include('metode.create')
@include('metode.edit')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="ml-auto">
                        <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_metode"><i class="fa fa-plus"></i> Tambah Metode</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_id" class="table table-bordered table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Metode</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
    $(document).ready(function(){
        $('#table_id').DataTable();
     })
</script>

<!-- Fetch Data -->
<script>
    $.ajax({
        url: "/metode/get-data",
        type: "GET",
        dataType: 'JSON',
        success: function(response){
            let counter = 1;
            $('#table_id').DataTable().clear();
            $.each(response.data, function(key, value){
                let metode = `
                <tr class="barang-row" id="index_${value.id}">
                    <td>${counter++}</td>   
                    <td>${value.metode}</td>
                    <td>
                        <a href="javascript:void(0)" id="button_edit_metode" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                        <a href="javascript:void(0)" id="button_hapus_metode" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                    </td>
                </tr>
            `;
            $('#table_id').DataTable().row.add($(metode)).draw(false);
            });
        }
    });
</script>

<!-- Show Modal Tambah & Function Store Data -->
<script>
    $('body').on('click', '#button_tambah_metode', function(){
        $('#modal_tambah_metode').modal('show');
        clearAlert();
    });

    function clearAlert(){
        $('#alert-metode').removeClass('d-block').addClass('d-none');
    }

    $('#store').click(function(e){
        e.preventDefault();

        let metode   = $('#metode').val();
        let token    = $("meta[name='csrf-token']").attr("content");

        let formData = new FormData();
        formData.append('metode', metode);
        formData.append('_token', token);

        $.ajax({
            url : '/metode',
            type: "POST",
            cache: false,
            data: formData,
            contentType: false,
            processData: false,

            success:function(response){
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: true,
                    timer: 3000
                });

                $.ajax({
                    url : '/metode/get-data',
                    type: "GET",
                    cache: false,
                    success:function(response){

                        let counter = 1;
                        $('#table_id').DataTable().clear();
                        $.each(response.data, function(key, value){
                            let metode = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>   
                                    <td>${value.metode}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_edit_metode" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                        <a href="javascript:void(0)" id="button_hapus_metode" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                             `;
                        $('#table_id').DataTable().row.add($(metode)).draw(false);
                        });

                        $('#metode').val('');
                        $('#modal_tambah_metode').modal('hide');

                        let table = $('#table_id').DataTable();
                        table.draw();
                    },
                    error:function(error){
                        console.log(error);
                    }
                })
            },

            error:function(error){
                if(error.responseJSON && error.responseJSON.metode && error.responseJSON.metode[0]){
                    $('#alert-metode').removeClass('d-none');
                    $('#alert-metode').addClass('d-block');

                    $('#alert-metode').html(error.responseJSON.metode[0]);
                }
            }
        });
    });
</script>
    

<!-- Show Modal Edit & Update Proccess -->
<script>
    $('body').on('click', '#button_edit_metode', function(){
        let metode_id = $(this).data('id');
        clearAlert();

        $.ajax({
            url: `/metode/${metode_id}/edit`,
            type: "GET",
            cache: false,
            success:function(response){
                $('#metode_id').val(response.data.id);
                $('#edit_metode').val(response.data.metode);

                $('#modal_edit_metode').modal('show');
            }
        });
    });

    function clearAlert(){
        $('#alert-metode').removeClass('d-block').addClass('d-none');
    }

    $('#update').click(function(e){
        e.preventDefault();

        let metode_id   = $('#metode_id').val();
        let metode      = $('#edit_metode').val();
        let token         = $("meta[name='csrf-token']").attr('content');

        let formData = new FormData();
        formData.append('metode', metode);
        formData.append('_token', token);
        formData.append('_method', 'PUT');

        $.ajax({
            url: `/metode/${metode_id}`,
            type: "POST",
            cache: false,
            data: formData,
            contentType: false,
            processData: false,

            success:function(response){
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: true,
                    timer:3000
                });

                let row = $(`#index_${response.data.id}`);
                let rowData = row.find('td');
                rowData.eq(1).text(response.data.metode);
                
                $('#modal_edit_metode').modal('hide');
            },
            
            error:function(error){
                if(error.responseJSON && error.responseJSON.edit_metode && error.responseJSON.edit_metode[0]){
                    $('#alert-edit_metode').removeClass('d-none');
                    $('#alert-edit_metode').addClass('d-block');

                    $('#alert-edit_metode').html(error.responseJSON.edit_metode[0]);
                }
            }
        });
    });
</script>

<!-- Modal Delete Data -->
<script>
    $('body').on('click', '#button_hapus_metode', function(){
            let metode_id = $(this).data('id');
            let token       = $("meta[name='csrf-token']").attr("content");
    
            Swal.fire({
                    title: 'Apakah Kamu Yakin?',
                    text: "ingin menghapus data ini !",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'TIDAK',
                    confirmButtonText: 'YA, HAPUS!'
                }).then((result) => {
                    if(result.isConfirmed){
                        $.ajax({
                            url: `/metode/${metode_id}`,
                            type: "DELETE",
                            cache: false,
                            data: {
                                "_token": token
                            },
                            success:function(response){
                                Swal.fire({
                                    type: 'success',
                                    icon: 'success',
                                    title: `${response.message}`,
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                                $('#table_id').DataTable().clear().draw();
    
                                $.ajax({
                                    url: "/metode/get-data",
                                    type: "GET",
                                    dataType: 'JSON',
                                    success: function(response){
                                        let counter = 1;
                                        $('#table_id').DataTable().clear();
                                        $.each(response.data, function(key, value){
                                            let metode = `
                                            <tr class="barang-row" id="index_${value.id}">
                                                <td>${counter++}</td>   
                                                <td>${value.metode}</td>
                                                <td>
                                                    <a href="javascript:void(0)" id="button_edit_metode" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                                    <a href="javascript:void(0)" id="button_hapus_metode" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                                </td>
                                            </tr>
                                        `;
                                        $('#table_id').DataTable().row.add($(metode)).draw(false);
                                        });
                                    }
                                });
                            }
                        })
                    }
                });
            });
    </script>
@endsection