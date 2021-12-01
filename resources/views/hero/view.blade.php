@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>{{ __('View Hero') }}</p>
                    
                </div>
                <div class="card-body">
                   <form action="{{ route('hero.update',['id' => $hero->id]) }}" method="POST">
                        @method('PUT')
                        <div class='d-flex justify-content-between align-items-center'>
                            <h5>{{ 'Detail Super Hero : '.$hero->nama }}</h5>
                            <div class="btn-group">
                                <button href="javascript:void(0)" class="btn btn-primary btn-sm">Simpan</button>
                                {{-- <form action="{{ route('hero.destroy',$hero->id) }}" method="POST">
                                    @method('delete')
                                    <button href="javascript:void(0)" class="btn btn-danger btn-sm">Hapus</button>
                                </form> --}}
                            </div>
                        </div>
                        <table class="table table-borderd ">
                            
                            <tr>
                                <td>ID</td>
                                <td>{{ $hero->id }}</td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td><input type="text" name="nama" value="{{ $hero->nama }}" class="form-control"></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>
                                    <select name="jenis_kelamin" class="form-control">
                                        <option value="">Pilih</option>
                                        @foreach ($jenis_kelamin as $value)
                                            <option value="{{ $value->jenis_kelamin }}" {{ $value->jenis_kelamin == $hero->jenis_kelamin ? 'selected' : '' }}>{{ $value->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </table>
                   </form>
                   <br>
                   <form action="{{ route('heroskill.store_skill',['hero_id' => $hero->id]) }}" class="form-horizontal" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-10">
                                <select name="skill_id" class="form-control">
                                    @foreach ($skill as $value)
                                        <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-sm">Tambah Skill</button>
                            </div>
                        </div>
                   </form>
                   <table class="table table-bordered" id="table">
                       <thead>
                           <tr>
                               <td>No</td>
                               <td>Skill</td>
                               <td></td>
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $no = 1;
                           @endphp
                           
                           @foreach ($hero->joinSkill as $value)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $value->nama.' - '.$value->pivot->id }}</td>
                                    <td>
                                        <form action="{{ route('heroskill.destroy_skill',['id' => $value->pivot->id, 'hero_id' => $hero->id]) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>    
                           @endforeach
                       </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
   
    <script>

    </script>
@endsection
