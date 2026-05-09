@extends('layouts.app')

@section('title', 'Analytics')
@section('page-title', 'Analytics')
@section('page-sub', 'Detailed analytics overview')

@section('content')
<div class="sgrid" style="margin-bottom:16px;">
  @foreach($metrics as $m)
  <div class="card sc">
    <div class="slb">{{ $m['label'] }}</div>
    <div class="sv">{{ $m['value'] }}</div>
    <div style="margin-top:5px;"><span class="bdg {{ $m['up'] ? 'bu' : 'bd' }}">{{ $m['up'] ? '▲' : '▼' }} {{ $m['change'] }}</span></div>
    <div class="prog-bar" style="margin-top:8px;"><div class="prog-fill" style="width:{{ $m['pct'] }}%;background:{{ $m['color'] }};"></div></div>
  </div>
  @endforeach
</div>

<div class="card" style="padding:28px;text-align:center;color:var(--tm);font-size:10px;">
  <div style="font-family:'Syne',sans-serif;font-size:18px;font-weight:700;color:var(--ac);margin-bottom:8px;">◈</div>
  <div style="font-size:11px;color:var(--tp);margin-bottom:4px;">Advanced Analytics</div>
  <div>Full chart suite coming soon. Connect your data source to enable.</div>
</div>
@endsection
