@extends('layouts.master')
@section('header',"Shopee Scrapper")
@section('shopee-active','active')

@section('content')

<div id="from-file-form"></div>

@endsection

@section('js')
<script>
    $('#csrf_token_field').val($("meta[name='csrf-token']").attr("content"));
    $('#btnBack').attr('href',"{{route('shopee')}}");
    $('#user_id_field').val({{Auth::user()->id}});
</script>
@endsection