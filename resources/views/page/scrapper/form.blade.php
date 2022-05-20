@extends('layouts.master')
@section('header',"Shopee Scrapper")
@section('shopee-active','active')

@section('content')

{{-- <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form>
                    @csrf

                    <div class="form-group">
                        <label for="" class="form-label">Link Shopee</label>
                        <textarea name="shopeelink" id="shopeelink" class="form-control"
                            placeholder="Enter link separate by comma" required style="height: 200px"></textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{route('users')}}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div> --}}

<div id="scrapper-form"></div>

@endsection

@section('js')
<script>
    $('#csrf_token_field').val($("meta[name='csrf-token']").attr("content"));
    $('#btnBack').attr('href',"{{route('shopee')}}");
</script>
@endsection