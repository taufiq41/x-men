@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>{{ __('View Skill') }}</p>
                    
                </div>
                <div class="card-body">
                   <form action="{{ route('skill.update',['id' => $skill->id]) }}" method="POST">
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
                                <td>{{ $skill->id }}</td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td><input type="text" name="nama" value="{{ $skill->nama }}" class="form-control"></td>
                            </tr>
                        </table>
                   </form>
                   <br>
                   <form action="{{ route('heroskill.store',['skill_id' => $skill->id]) }}" class="form-horizontal" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-10">
                                <select name="hero_id" class="form-control">
                                    @foreach ($hero as $value)
                                        <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-sm">Tambah Hero</button>
                            </div>
                        </div>
                   </form>
                   <table class="table table-bordered" id="table">
                       <thead>
                           <tr>
                               <td>No</td>
                               <td>hero</td>
                               <td></td>
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $no = 1;
                           @endphp
                           
                           @foreach ($skill->joinHero as $value)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $value->nama.' - '.$value->pivot->id }}</td>
                                    <td>
                                        <form action="{{ route('heroskill.destroy2',['id' => $value->pivot->id, 'skill_id' => $skill->id]) }}" method="POST">
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

@endsection
