<?php use App\Enums\CareCategory; ?>

@extends('layouts.app')

@section('content')
    <div class="d-flex flex-sm-row my-5 mx-3">
        <div class="col-sm-6 p-0">
            <h4>編集</h4>
            @if (!\Auth::user()->isOkakiUser())
            <p class="text-danger">※このアカウントでは編集できません</p>
            @endif
        </div>
        @if (\Auth::user()->isOkakiUser())
        <div class="col-sm-6 text-right">
            {!! Form::model($care,  ['route' => ['care.destroy', $care->id], 'method' => 'delete', 'id' => 'careDeleteForm']) !!}
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#careDeleteDialog">削除</button>
            {!! Form::close() !!}
        </div>
        
        <div class="modal fade" id="careDeleteDialog" tabindex="-1" role="dialog" aria-labelledby="careDeleteDialog" aria-hidden="true">
          <div class="modal-dialog modal-sm modal-dialog-center" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">削除確認</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                本当に削除しますか？
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                <button type="button" id="careDeleteBtn" class="btn btn-danger">削除</button>
              </div>
            </div>
          </div>
        </div>
        @endif
    </div>
    
    @if (count($errors) > 0)
        <ul class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                <li class="ml-4">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    
    <div class="row mx-3">
        <div class="col-12">
            {!! Form::model($care,  ['route' => ['care.update', $care->id], 'method' => 'put']) !!}

                <div class="form-group row">
                    {!! Form::label('care_date', '日付', ['class' => 'col-sm-3 p-0']) !!}
                    {!! Form::date('care_date', $care->getCareDateTime(), ['class' => 'form-control col-sm-4', 'readonly']) !!}
                </div>
                
                <div class="form-group row"> 
                    {!! Form::label('care_time', '時間', ['class' => 'col-sm-3 p-0']) !!}
                    {!! Form::time('care_time', $care->getCareDateTime(), ['class' => 'form-control col-sm-4']) !!}
                </div>
                
                <div class="form-group row">
                    {!! Form::label('category_text', '内容', ['class' => 'col-sm-3 p-0']) !!}
                    {!! Form::text('category_text', CareCategory::getName($care->category), ['class'=>'form-control col-sm-4', 'readonly']) !!}
                </div>
                {!! Form::hidden('category', $care->category, ['id' => 'category']) !!}
                
                @if ($food_supply_amount !== null)
                <div class="form-group row food-supply-item">
                    {!! Form::label('food_supply_amount', 'ごはん量(g)', ['class' => 'col-sm-3 p-0']) !!}
                    {!! Form::number('food_supply_amount', $food_supply_amount, ['class'=>'form-control col-sm-4']) !!}
                </div>
                @endif
                
                @if (\Auth::user()->isOkakiUser())
                <div class="form-group row">
                    {!! Form::label('memo', 'メモ', ['class' => 'col-sm-3 p-0']) !!}
                    {!! Form::textarea('memo', null, ['class' => 'form-control col-sm-8', 'rows' => '5']) !!}
                </div>
                @endif

                <div class="d-flex flex-sm-row">
                    <div class="col-sm-6 text-right">
                        <button type="button" class="btn btn-secondary" onclick="location.href='/{{ $care->getCareDateTime()->year }}/{{ $care->getCareDateTime()->month }}'">戻る</button>
                    </div>
                    @if (\Auth::user()->isOkakiUser())
                    <div class="col-sm-6">
                        {!! Form::submit('更新', ['class' => 'btn btn-primary']) !!}
                    </div>
                    @endif
                </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection