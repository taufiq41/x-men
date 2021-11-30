@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>{{ __('Data Skill') }}</p>
                    <a href="javascript:void(0)" onclick="add()" class="btn btn-primary btn-sm">Tambah</a>
                </div>
                <div class="card-body">
                   <table class="table table-bordered" id="table">
                       <thead>
                           <tr>
                               <td>No</td>
                               <td>Skill</td>
                               <td></td>
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
@endsection

@section('modal')
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="form">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="save()" id="btnSave">Simpan</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection

@section('script')
   <script>
        var table;
        var actionModal;
        var idForm;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            loadTable();
        });

        function loadTable(){
            if(table != null){
                table.destroy();
            }
            table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                bLengthChange: true,
                bFilter: true,
                bAutoWidth: true,
                buttons: [
                ],
                ajax: {
                    url : '{{ route('skill.datatable') }}',
                    method : 'POST'
                },
                columnDefs: [
                    {
                        targets: [0],
                        render: function ( data, type, row, meta ) {
                            return 'no';
                        }
                    },
                    {
                        targets: [1],
                        render: function ( data, type, row, meta ) {
                            return data;
                        }
                    },
                    {
                        targets: [2],
                        className: 'text-center',
                        render: function ( data, type, row, meta ) {
                            
                            var component = '<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick=edit("'+data+'")><i class="fa fa-edit"> </i>Edit</a>';   
                            component = '<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick=hapus("'+data+'")><i class="fa fa-trash"> </i>Hapus</a>';
                            return component;
                        }
                    }
                ],
                columns: [
                    { },
                    { data: 'nama', name: 'nama' },
                    { data: 'id', name: 'id' }
                ],
                search: {
                    regex: true
                },
            });
        }

        function clearFormValidation(){
            $("#form").find("div").find("input").removeClass("is-invalid");
            $("#form").find("div").find("select").removeClass("is-invalid");
            $("#form").find("div").find("span").remove(".invalid-feedback");
        }
        
        function resetForm(){
            $('#form')[0].reset();
            clearFormValidation();
            $('#btnSave').text('Simpan');
            $('#btnSave').attr('disabled', false);
            idForm = "";
        }
        
        function add(){
            actionModal = 'add';
        
            resetForm();
            $('#modal').modal('show');
            $('.modal-title').text('Tambah Skill Baru');
        }

        function edit(id){   
        
            actionModal = 'update';
            resetForm();
            
            $.ajax({
                url : "{{ url('') }}/skill/edit/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('#modal').modal('show');
                    $('.modal-title').text('Ubah Data Hero');
                    idForm = data.id;
                    $("input[name=nama]").val(data.nama);
                    
                }
            });
        }

        function save(){
        
            $('#btnSave').text('Menyimpan...');
            $('#btnSave').attr('disabled', true);
            var url;
            var formData = new FormData($('#form')[0]);
            
            if (actionModal == 'add') {
                url = '{{ route('skill.store') }}';
                type = "POST";
            } else {
                url = "{{ url('') }}/skill/update/"+idForm;
                type = "POST";
                formData.append('_method','PUT');
            }
            $.ajax({
                url: url,
                type: type,
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data)
                {
                    if($.isEmptyObject(data.error)){
                        if(data.result){
                            toastr.success(data.keterangan);
                            $('#modal').modal('hide');
                            resetForm();
                            loadTable();
                        }else{
                            toastr.error(data.keterangan);
                        }
                        
                    }else{
                        
                        printErrorMsg(data.error);
                        $('#btnSave').text('Simpan');
                        $('#btnSave').attr('disabled', false);
                    }
                }
            });
            
        }
        
        function printErrorMsg (msg) {
                
            clearFormValidation();
            
            $.each( msg, function( key, value ) {
                var component = "<span class='invalid-feedback' role='alert'>";
                component += "<strong>"+value+"</strong></span>";
            
                var cariComponent = $("#form").find("div").find("input[name="+key+"]");
                
                cariComponent.addClass("is-invalid");
                
                $(component).insertAfter(cariComponent);
                  
                
            });
        }

        function hapus(id){

            Swal.fire({
                title: 'Yakin hapus data skill?',
                text: "pastikan skill yang dihapus sudah tidak di pakai pada Hero",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                if (result.isConfirmed) {

                    var url = "{{ url('') }}/skill/destroy/"+id;

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data:{'_method' : 'DELETE'},
                        dataType: "JSON",
                        success: function(data){

                            if(data.result){
                                
                                loadTable();
                            }else{
                                
                            } 

                        }
                    });

                }
                });
            }
   </script>
@endsection
