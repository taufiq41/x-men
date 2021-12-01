@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/datatable/Buttons-2.0.1/css/buttons.dataTables.min.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>{{ __('Data Hero') }}</p>
                    <a href="javascript:void(0)" onclick="add()" class="btn btn-primary btn-sm">Tambah</a>
                </div>
                <div class="card-body">
                   <table class="table table-bordered" id="table">
                       <thead>
                           <tr>
                               <td>Hero</td>
                               <td>Jenis Kelamin</td>
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
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="">Pilih</option>
                            @foreach ($jenis_kelamin as $value)
                                <option value="{{ $value->jenis_kelamin }}">{{ $value->nama }}</option>
                            @endforeach
                        </select>
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

    <script src="{{ asset('vendor/datatable/Buttons-2.0.1/js/dataTables.buttons.min.js') }}" defer></script>
    <script src="{{ asset('vendor/datatable/JSZip-2.5.0/jszip.min.js') }}" defer></script>
    <script src="{{ asset('vendor/datatable/pdfmake-0.1.3.6/pdfmake.min.js') }}" defer></script>
    <script src="{{ asset('vendor/datatable/pdfmake-0.1.3.6/vfs_fonts.js') }}" defer></script>
    <script src="{{ asset('vendor/datatable/Buttons-2.0.1/js/buttons.html5.min.js') }}" defer></script>
    <script src="{{ asset('vendor/datatable/Buttons-2.0.1/js/buttons.print.min.js') }}" defer></script>
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
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                searching: true,
                bLengthChange: true,
                bFilter: true,
                bAutoWidth: true,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                ajax: {
                    url : '{{ route('hero.datatable') }}',
                    method : 'POST'
                },
                columnDefs: [
                    {
                        targets: [0],
                        render: function ( data, type, row, meta ) {
                            return data;
                        }
                    },
                    {
                        targets: [1],
                        render: function ( data, type, row, meta ) {
                            return data[0].nama;
                        }
                    },
                    {
                        targets: [2],
                        className: 'text-center',
                        render: function ( data, type, row, meta ) {

                            var url = "{{ url('') }}/hero/show/"+data;
                            
                            var component = '<a href="'+url+'" class="btn btn-warning btn-sm"><i class="fa fa-edit"> </i>Detail</a>';   
                            component += '<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick=hapus("'+data+'")><i class="fa fa-edit"> </i>Hapus</a>';
                            return component;
                        }
                    }
                ],
                columns: [
                    { data: 'nama', name: 'nama' },
                    { data: 'join_jenis_kelamin', name: 'join_jenis_kelamin' },
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
            $('.modal-title').text('Tambah Hero Baru');
        }

        function edit(id){   
        
            actionModal = 'update';
            resetForm();
            
            $.ajax({
                url : "{{ url('') }}/hero/edit/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('#modal').modal('show');
                    $('.modal-title').text('Ubah Data Hero');
                    idForm = data.id;
                    $("input[name=nama]").val(data.nama);
                    $("select[name=jenis_kelamin]").val(data.jenis_kelamin);
                    
                }
            });
        }

        function save(){
        
            $('#btnSave').text('Menyimpan...');
            $('#btnSave').attr('disabled', true);
            var url;
            var formData = new FormData($('#form')[0]);
            
            if (actionModal == 'add') {
                url = '{{ route('hero.store') }}';
                type = "POST";
            } else {
                url = "{{ url('') }}/hero/update/"+idForm;
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
                if(key == "jenis_kelamin"){
                    var cariComponent = $("#form").find("div").find("select[name="+key+"]");
                    cariComponent.addClass("is-invalid");
                    $(component).insertAfter(cariComponent);
                }else{
                    var cariComponent = $("#form").find("div").find("input[name="+key+"]");
                    
                    cariComponent.addClass("is-invalid");
                    
                    $(component).insertAfter(cariComponent);
                }    
                
            });
        }

        function hapus(id){

            Swal.fire({
                title: 'Yakin hapus hero?',
                text: "hero yang terhapus tidak bisa dikembalikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                if (result.isConfirmed) {

                    var url = "{{ url('') }}/hero/destroy/"+id;

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
