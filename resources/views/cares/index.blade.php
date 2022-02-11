<?php use App\Enums\CareCategory; ?>

@extends('layouts.app')

@section('content')

<div class="d-flex flex-sm-row my-5">
    <div class="col-sm-6">
        <h4>おかきの記録</h4>
        @if (!\Auth::user()->isOkakiUser())
            <p class="text-danger">※このアカウントでは登録・編集できません</p>
        @endif
    </div>
    <div class="pos-f-t small col-sm-6">
        <div class="navbar-toggler text-right" data-toggle="collapse" data-target="#iconToggleExternalContent" aria-controls="iconToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-question-circle"></i><span class="small">アイコンについて</span>
        </div>
        <div class="collapse" id="iconToggleExternalContent">
            <div class="p-1">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-info"><i class="fas fa-tint mr-2"></i>水交換</li>
                    <li class="list-group-item list-group-item-info"><i class="fas fa-filter mr-2"></i>フィルター交換</li>
                    <li class="list-group-item list-group-item-info"><i class="fas fa-hospital mr-2"></i>病院</li>
                    <li class="list-group-item list-group-item-info"><i class="fas fa-fish mr-2"></i>ごはん補給</li>
                    <li class="list-group-item list-group-item-info"><i class="fas fa-comment-dots mr-2"></i>その他</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="d-flex flex-sm-row my-3">
    <div class="col-sm-3 text-left"><a href="/{{ $prev_year }}/{{ $prev_month }}"><i class="fas fa-chevron-left fa-2x"></i></a></div>
    <div class="col-sm-6 text-center py-2">{{ $current_year }}年{{ $current_month }}月</div>
    <div class="col-sm-3 text-right"><a href="/{{ $next_year }}/{{ $next_month }}"><i class="fas fa-chevron-right fa-2x"></i></a></a></div>
</div>

<div class="table-responsive-sm">
    <table class="table table-bordered"> 
        <thead class="thead-light">
            <tr class="text-center">
                @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
                    <th>{{ $dayOfWeek }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($calendar_days as $day)
                @if ($day['day']->dayOfWeek == 0)
                <tr>
                @endif
                
                @if ($day['day']->day === 1)
                    @for ($i = 0; $i < $day['day']->dayOfWeek; $i++)
                        <td></td>
                    @endfor
                @endif
    
                <td>
                    <div class="d-flex flex-sm-row my-1">
                        <div class="col-sm-8">
                            {{ $day['day']->day }}
                        </div>
                        
                        @if (count($day['cares']) !== count(CareCategory::getAll()))
                            <div class="col-sm-4">
                                <a href="/care/create/{{ $day['day']->year }}/{{ $day['day']->month }}/{{ $day['day']->day }}"><i class="fas fa-plus-circle"></i></a>
                            </div>
                        @endif
                    </div>
    
                    @if (count($day['cares']) > 0)
                        <div class="pos-f-t py-3">
                            <div class="navbar-toggler text-left" data-toggle="collapse" data-target="#careCategoryList{{ $day['day']->day}}" aria-controls="careCategoryList" aria-expanded="false" aria-label="Toggle navigation">
                              <i class="fas fa-list"></i>
                            </div>
                            <div class="collapse" id="careCategoryList{{ $day['day']->day}}">
                                <ul class="list-group list-group-flush">
                                @foreach ($day['cares'] as $care)
                                    <li class="list-group-item list-group-item-light text-center">
                                        <a href="/care/{{ $care->id }}/edit">
                                            @if ($care->category === CareCategory::EXCHANGE_WATER)
                                                <span><i class="fas fa-tint"></i></span>
                                            @endif
                                            @if ($care->category === CareCategory::EXCHANGE_FILTER)
                                                <span><i class="fas fa-filter"></i></span>
                                            @endif
                                            @if ($care->category === CareCategory::HOSPITAL)
                                                <span><i class="fas fa-hospital"></i></span>
                                            @endif
                                            @if ($care->category === CareCategory::FOOD_SUPPLY)
                                                <span><i class="fas fa-fish"></i></span>
                                            @endif
                                            @if ($care->category === CareCategory::OTHER)
                                                <span><i class="fas fa-comment-dots"></i></span>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </td>
                
                @if ($day['day']->dayOfWeek == 6)
                    </tr>
                @endif
                
            @endforeach
        </tbody>
    </table>
</div>

@endsection