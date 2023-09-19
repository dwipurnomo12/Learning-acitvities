@extends('layouts.main')

@include('activity.create')
@include('activity.edit')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="ml-auto">
                        <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_activity"><i class="fa fa-plus"></i> Tambah activity</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_id" class="table table-bordered table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>activity</th>
                                    <th>Metode</th>
                                    <th>Bulan</th>
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
        url: "/activity/get-data",
        type: "GET",
        dataType: 'JSON',
        success: function(response){
            let counter = 1;
            $('#table_id').DataTable().clear();
            $.each(response.data, function(key, value){
                let activity = `
                <tr class="barang-row" id="index_${value.id}">
                    <td>${counter++}</td>   
                    <td>${value.activity}</td>
                    <td>${value.metode.metode}</td>
                    <td>${value.bulan.bulan}</td>
                    <td>
                        <a href="javascript:void(0)" id="button_edit_activity" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                        <a href="javascript:void(0)" id="button_hapus_activity" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                    </td>
                </tr>
            `;
            $('#table_id').DataTable().row.add($(activity)).draw(false);
            });
        }
    });
</script>

<!-- Show Modal Tambah & Function Store Data -->
<script>
    $('body').on('click', '#button_tambah_activity', function(){
        $('#modal_tambah_activity').modal('show');
        clearAlert();
    });

    function clearAlert(){
        $('#alert-activity').removeClass('d-block').addClass('d-none');
    }

    $('#store').click(function(e){
        e.preventDefault();

        let activity    = $('#activity').val();
        let metode_id   = $('#metode_id').val();
        let bulan_id    = $('#bulan_id').val();
        let token       = $("meta[name='csrf-token']").attr("content");

        let formData = new FormData();
        formData.append('activity', activity);
        formData.append('metode_id', metode_id);
        formData.append('bulan_id', bulan_id);
        formData.append('_token', token);

        $.ajax({
            url : '/activity',
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
                    url : '/activity/get-data',
                    type: "GET",
                    cache: false,
                    success:function(response){

                        let counter = 1;
                        $('#table_id').DataTable().clear();
                        $.each(response.data, function(key, value){
                            let activity = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>   
                                    <td>${value.activity}</td>
                                    <td>${value.metode.metode}</td>
                                    <td>${value.bulan.bulan}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_edit_activity" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                        <a href="javascript:void(0)" id="button_hapus_activity" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                             `;
                        $('#table_id').DataTable().row.add($(activity)).draw(false);
                        });

                        $('#activity').val('');
                        $('#metode_id').val('');
                        $('#bulan_id').val('');
                        $('#modal_tambah_activity').modal('hide');

                        let table = $('#table_id').DataTable();
                        table.draw();
                    },
                    error:function(error){
                        console.log(error);
                    }
                })
            },

            error:function(error){
                if(error.responseJSON && error.responseJSON.activity && error.responseJSON.activity[0]){
                    $('#alert-activity').removeClass('d-none');
                    $('#alert-activity').addClass('d-block');

                    $('#alert-activity').html(error.responseJSON.activity[0]);
                }
                if(error.responseJSON && error.responseJSON.bulan_id && error.responseJSON.bulan_id[0]){
                    $('#alert-bulan_id').removeClass('d-none');
                    $('#alert-bulan_id').addClass('d-block');

                    $('#alert-bulan_id').html(error.responseJSON.bulan_id[0]);
                }
                if(error.responseJSON && error.responseJSON.metode_id && error.responseJSON.metode_id[0]){
                    $('#alert-metode_id').removeClass('d-none');
                    $('#alert-metode_id').addClass('d-block');

                    $('#alert-metode_id').html(error.responseJSON.metode_id[0]);
                }
            }
        });
    });
</script>
    

<!-- Show Modal Edit & Update Proccess -->
<script>
    $('body').on('click', '#button_edit_activity', function(){
        let activity_id = $(this).data('id');
        clearAlert();

        $.ajax({
            url: `/activity/${activity_id}/edit`,
            type: "GET",
            cache: false,
            success:function(response){
                $('#activity_id').val(response.data.id);
                $('#edit_activity').val(response.data.activity);
                $('#edit_metode_id').val(response.data.metode_id);
                $('#edit_bulan_id').val(response.data.bulan_id);

                $('#modal_edit_activity').modal('show');
            }
        });
    });

    function clearAlert(){
        $('#alert-activity').removeClass('d-block').addClass('d-none');
        $('#alert-metode_id').removeClass('d-block').addClass('d-none');
        $('#alert-bulan_id').removeClass('d-block').addClass('d-none');
    }

    $('#update').click(function(e){
        e.preventDefault();

        let activity_id   = $('#activity_id').val();
        let activity      = $('#edit_activity').val();
        let metode_id     = $('#edit_metode_id').val();
        let bulan_id      = $('#edit_bulan_id').val();
        let token         = $("meta[name='csrf-token']").attr('content');

        let formData = new FormData();
        formData.append('activity', activity);
        formData.append('metode_id', metode_id);
        formData.append('bulan_id', bulan_id);
        formData.append('_token', token);
        formData.append('_method', 'PUT');

        $.ajax({
            url: `/activity/${activity_id}`,
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
                rowData.eq(1).text(response.data.activity);
                rowData.eq(2).text(response.data.metode.metode);
                rowData.eq(3).text(response.data.bulan.bulan);
                
                $('#modal_edit_activity').modal('hide');
            },
            
            error:function(error){
                if(error.responseJSON && error.responseJSON.edit_activity && error.responseJSON.edit_activity[0]){
                    $('#alert-edit_activity').removeClass('d-none');
                    $('#alert-edit_activity').addClass('d-block');

                    $('#alert-edit_activity').html(error.responseJSON.edit_activity[0]);
                }
                if(error.responseJSON && error.responseJSON.bulan_id && error.responseJSON.bulan_id[0]){
                    $('#alert-bulan_id').removeClass('d-none');
                    $('#alert-bulan_id').addClass('d-block');

                    $('#alert-bulan_id').html(error.responseJSON.bulan_id[0]);
                }
                if(error.responseJSON && error.responseJSON.metode_id && error.responseJSON.metode_id[0]){
                    $('#alert-metode_id').removeClass('d-none');
                    $('#alert-metode_id').addClass('d-block');

                    $('#alert-metode_id').html(error.responseJSON.metode_id[0]);
                }
            }
        });
    });
</script>

<!-- Modal Delete Data -->
<script>
    $('body').on('click', '#button_hapus_activity', function(){
            let activity_id = $(this).data('id');
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
                            url: `/activity/${activity_id}`,
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
                                    url: "/activity/get-data",
                                    type: "GET",
                                    dataType: 'JSON',
                                    success: function(response){
                                        let counter = 1;
                                        $('#table_id').DataTable().clear();
                                        $.each(response.data, function(key, value){
                                            let activity = `
                                            <tr class="barang-row" id="index_${value.id}">
                                                <td>${counter++}</td>   
                                                <td>${value.activity}</td>
                                                <td>${value.metode.metode}</td>
                                                <td>${value.bulan.bulan}</td>
                                                <td>
                                                    <a href="javascript:void(0)" id="button_edit_activity" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                                    <a href="javascript:void(0)" id="button_hapus_activity" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                                </td>
                                            </tr>
                                        `;
                                        $('#table_id').DataTable().row.add($(activity)).draw(false);
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