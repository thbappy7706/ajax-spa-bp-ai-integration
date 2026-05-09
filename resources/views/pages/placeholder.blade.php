@extends('layouts.app')

@section('title', $pageTitle)
@section('page-title', $pageTitle)
@section('page-sub', $pageSub)

@section('content')
<div class="card" style="padding:48px 28px;text-align:center;">
  <div style="font-size:28px;margin-bottom:12px;">{{ $icon }}</div>
  <div style="font-family:'Syne',sans-serif;font-size:13px;font-weight:700;margin-bottom:6px;">{{ $pageTitle }}</div>
  <div style="font-size:10px;color:var(--tm);">{{ $pageSub }}</div>
  <div style="margin-top:16px;display:inline-flex;gap:8px;">
    <span class="bdg bu">Under Construction</span>
  </div>
</div>
@endsection
