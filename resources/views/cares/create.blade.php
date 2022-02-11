<?php use App\Enums\CareCategory; ?>

@extends('layouts.app')

@section('content')
    <div class="d-flex flex-sm-row my-5 mx-3">
        <div class="col-sm-6 p-0">
            <h4>新規登録</h4>
            @if (!\Auth::user()->isOkakiUser())
            <p class="text-danger">※このアカウントでは登録できません</p>
            @endif
        </div>
    </div>
    
    @if (count($errors) > 0)
        <ul class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                <li class="ml-4">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    
    <div class="row mx-3">
        <div class="col-sm-12">
            {!! Form::model($care, ['route' => 'care.store']) !!}
                @csrf

                <div class="form-group row">
                    {!! Form::label('care_date', '日付', ['class' => 'col-sm-3 p-0']) !!}
                    {!! Form::date('care_date', $now, ['class' => 'form-control col-sm-4']) !!}
                </div>

                <div class="form-group row">
                    {!! Form::label('care_time', '時間', ['class' => 'col-sm-3 p-0']) !!}
                    {!! Form::time('care_time', $now, ['class' => 'form-control col-sm-4']) !!}
                </div>
                
                <div class="form-group row">
                    {!! Form::label('category', '内容', ['class' => 'col-sm-3 p-0']) !!}
                    {!! Form::select('category', CareCategory::getAll(), null, ['class'=>'form-control col-sm-4']) !!}
                </div>
                
                <!-- ごはん補給が選択された時表示する -->
                <div class="form-group row food-supply-item">
                    {!! Form::label('food_supply_amount', 'ごはん量(g)', ['class' => 'col-sm-3 p-0']) !!}
                    {!! Form::number('food_supply_amount', '0', ['class'=>'form-control col-sm-4']) !!}
                </div>
                
                <div class="form-group row">
                    {!! Form::label('memo', 'メモ', ['class' => 'col-sm-3 p-0']) !!}
                    {!! Form::textarea('memo', old('memo'), ['class' => 'form-control col-sm-8', 'rows' => '9']) !!}
                </div>

                <div class="d-flex flex-sm-row">
                    <div class="col-sm-6 text-right">
                        <button type="button" class="btn btn-secondary" onclick="location.href='/{{ $now->year }}/{{ $now->month }}'">戻る</button>
                    </div>
                    @if (\Auth::user()->isOkakiUser())
                    <div class="col-sm-6">
                        {!! Form::submit('登録', ['class' => 'btn btn-primary']) !!}
                    </div>
                    @endif
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection