@extends('layouts.main')

@include('bulan.create')
@include('bulan.edit')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="ml-auto">
                        <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_bulan"><i class="fa fa-plus"></i> Tambah bulan</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_id" class="table table-bordered table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>bulan</th>
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
        url: "/bulan/get-data",
        type: "GET",
        dataType: 'JSON',
        success: function(response){
            let counter = 1;
            $('#table_id').DataTable().clear();
            $.each(response.data, function(key, value){
                let bulan = `
                <tr class="barang-row" id="index_${value.id}">
                    <td>${counter++}</td>   
                    <td>${value.bulan}</td>
                    <td>
                        <a href="javascript:void(0)" id="button_edit_bulan" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                        <a href="javascript:void(0)" id="button_hapus_bulan" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                    </td>
                </tr>
            `;
            $('#table_id').DataTable().row.add($(bulan)).draw(false);
            });
        }
    });
</script>

<!-- Show Modal Tambah & Function Store Data -->
<script>
    $('body').on('click', '#button_tambah_bulan', function(){
        $('#modal_tambah_bulan').modal('show');
        clearAlert();
    });

    function clearAlert(){
        $('#alert-bulan').removeClass('d-block').addClass('d-none');
    }

    $('#store').click(function(e){
        e.preventDefault();

        let bulan    = $('#bulan').val();
        let token    = $("meta[name='csrf-token']").attr("content");

        let formData = new FormData();
        formData.append('bulan', bulan);
        formData.append('_token', token);

        $.ajax({
            url : '/bulan',
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
                    url : '/bulan/get-data',
                    type: "GET",
                    cache: false,
                    success:function(response){

                        let counter = 1;
                        $('#table_id').DataTable().clear();
                        $.each(response.data, function(key, value){
                            let bulan = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>   
                                    <td>${value.bulan}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_edit_bulan" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                        <a href="javascript:void(0)" id="button_hapus_bulan" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                             `;
                        $('#table_id').DataTable().row.add($(bulan)).draw(false);
                        });

                        $('#bulan').val('');
                        $('#modal_tambah_bulan').modal('hide');

                        let table = $('#table_id').DataTable();
                        table.draw();
                    },
                    error:function(error){
                        console.log(error);
                    }
                })
            },

            error:function(error){
                if(error.responseJSON && error.responseJSON.bulan && error.responseJSON.bulan[0]){
                    $('#alert-bulan').removeClass('d-none');
                    $('#alert-bulan').addClass('d-block');

                    $('#alert-bulan').html(error.responseJSON.bulan[0]);
                }
            }
        });
    });
</script>
    

<!-- Show Modal Edit & Update Proccess -->
<script>
    $('body').on('click', '#button_edit_bulan', function(){
        let bulan_id = $(this).data('id');
        clearAlert();

        $.ajax({
            url: `/bulan/${bulan_id}/edit`,
            type: "GET",
            cache: false,
            success:function(response){
                $('#bulan_id').val(response.data.id);
                $('#edit_bulan').val(response.data.bulan);

                $('#modal_edit_bulan').modal('show');
            }
        });
    });

    function clearAlert(){
        $('#alert-bulan').removeClass('d-block').addClass('d-none');
    }

    $('#update').click(function(e){
        e.preventDefault();

        let bulan_id   = $('#bulan_id').val();
        let bulan      = $('#edit_bulan').val();
        let token         = $("meta[name='csrf-token']").attr('content');

        let formData = new FormData();
        formData.append('bulan', bulan);
        formData.append('_token', token);
        formData.append('_method', 'PUT');

        $.ajax({
            url: `/bulan/${bulan_id}`,
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
                rowData.eq(1).text(response.data.bulan);
                
                $('#modal_edit_bulan').modal('hide');
            },
            
            error:function(error){
                if(error.responseJSON && error.responseJSON.edit_bulan && error.responseJSON.edit_bulan[0]){
                    $('#alert-edit_bulan').removeClass('d-none');
                    $('#alert-edit_bulan').addClass('d-block');

                    $('#alert-edit_bulan').html(error.responseJSON.edit_bulan[0]);
                }
            }
        });
    });
</script>

<!-- Modal Delete Data -->
<script>
    $('body').on('click', '#button_hapus_bulan', function(){
            let bulan_id = $(this).data('id');
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
                            url: `/bulan/${bulan_id}`,
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
                                    url: "/bulan/get-data",
                                    type: "GET",
                                    dataType: 'JSON',
                                    success: function(response){
                                        let counter = 1;
                                        $('#table_id').DataTable().clear();
                                        $.each(response.data, function(key, value){
                                            let bulan = `
                                            <tr class="barang-row" id="index_${value.id}">
                                                <td>${counter++}</td>   
                                                <td>${value.bulan}</td>
                                                <td>
                                                    <a href="javascript:void(0)" id="button_edit_bulan" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                                    <a href="javascript:void(0)" id="button_hapus_bulan" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                                </td>
                                            </tr>
                                        `;
                                        $('#table_id').DataTable().row.add($(bulan)).draw(false);
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