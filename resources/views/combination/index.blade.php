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
                    <p>{{ __('Combination') }}</p>
                    
                </div>
                <div class="card-body">
                   <form action="#" method="POST" id="form">
                        
                        <div class='d-flex justify-content-between align-items-center'>
                            <h5>{{ 'Simulasi jika menikah'}}</h5>
                            <div class="btn-group">
                                <a href="javascript:void(0)" onclick="loadTable()" class="btn btn-primary btn-sm">Cek Simulasi</a>
                            </div>
                        </div>
                        <table class="table table-borderd ">
                            
                            <tr>
                                <td>Suami</td>
                                <td>
                                    <select name="hero_id_laki_laki" class="form-control">
                                        <option value="">Pilih</option>
                                        @foreach ($hero_laki_laki as $value)
                                            <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Istri</td>
                                <td>
                                    <select name="hero_id_perempuan" class="form-control">
                                        <option value="">Pilih</option>
                                        @foreach ($hero_perempuan as $value)
                                            <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </table>
                   </form>
                   <br>
                   <h6>Skill yang kemungkinan di miliki jika memiliki anak :</h6>
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


        function loadTable(){

            if(hero_id_laki_laki == "" || hero_id_perempuan == ""){
                alert("data harus di isi semua");
                exit;
            }

            var formData = new FormData($('#form')[0]);

            var hero_id_laki_laki = formData.get('hero_id_laki_laki');
            console.log(hero_id_laki_laki);
            var hero_id_perempuan = formData.get('hero_id_perempuan');

            
            if(table != null){
                table.destroy();
            }
            table = $('#table').DataTable({
                lengthMenu: [[-1], ["All"]],
                pagingType: "full_numbers",
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                searching: false,
                bLengthChange: true,
                bFilter: true,
                bAutoWidth: true,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                ajax: {
                    url : '{{ route('combination.datatable') }}',
                    method : 'POST',
                    data: {hero_id_laki_laki : hero_id_laki_laki, hero_id_perempuan : hero_id_perempuan}
                },
                columnDefs: [
                    {
                        targets: [0,1],
                        render: function ( data, type, row, meta ) {
                            return data[0].nama;
                        }
                    }
                ],
                columns: [
                    { data: 'nama', name: 'nama' },
                    { data: 'join_skill', name: 'join_skill' }
                ],
                search: {
                    regex: false
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
        }

        function printErrorMsg (msg) {
                
                clearFormValidation();
                
                $.each( msg, function( key, value ) {
                    var component = "<span class='invalid-feedback' role='alert'>";
                        component += "<strong>"+value+"</strong></span>";
                    
                    var cariComponent = $("#form").find("div").find("select[name="+key+"]");
                    cariComponent.addClass("is-invalid");
                    $(component).insertAfter(cariComponent);
                    
                    
                });
            }
    </script>
@endsection
