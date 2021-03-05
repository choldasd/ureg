@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                                 @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="street_address" class="col-md-4 col-form-label text-md-right">{{ __('Street Address') }}</label>
                            <div class="col-md-6">
                                <!--<input id="street_address" type="text" class="form-control basicAutoComplete @error('street_address') is-invalid @enderror"
                                name="street_address" value="{{ old('street_address') }}" required autocomplete="off">-->

                                <select class="form-control basicAutoSelect @error('street_address') is-invalid @enderror"
                                name="street_address" id="street_address" placeholder="type to search..." autocomplete="off"
                                value="{{ old('street_address') }}" required></select>
                                 @error('street_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>
                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                                value="{{ old('city') }}" required autocomplete="city">
                                 @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="state" class="col-md-4 col-form-label text-md-right">{{ __('State') }}</label>
                            <div class="col-md-6">
                                <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state"
                                value="{{ old('state') }}" required autocomplete="state">
                                 @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zip" class="col-md-4 col-form-label text-md-right">{{ __('Zip') }}</label>
                            <div class="col-md-6">
                                <input id="zip" type="text" class="form-control @error('zip') is-invalid @enderror" name="zip"
                                value="{{ old('zip') }}" required autocomplete="zip">
                                 @error('zip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        console.log("ok working.");

        /*$('.basicAutoComplete').autoComplete({
            resolverSettings: {
                url: "{{route('street')}}"
            }
        });*/
        $('.basicAutoSelect').autoComplete({
            resolver: 'custom',
            formatResult: function (item) {
                return {
                    value: item.street,
                    text:  item.text,
                };
            },
            events: {
                search: function (qry, callback) {
                    // let's do a custom ajax call
                    $.ajax(
                        "{{route('street')}}",{
                            data: { 'qry': qry}
                        }
                    ).done(function (res) {
                        if(res.status === true){
                            callback(res.data)
                        }
                    });
                }
            }
        });

        $('.basicAutoSelect').on('autocomplete.select', function (evt, item) {
            //$('#city').val(JSON.stringify(item));
            console.log(item);
            if(item != 'undefined' && item != undefined){
                $('#city').val(item.city);
                $('#street_address').val(item.street);
                $.ajax(
                    "{{route('zipcode')}}",{
                        data: { 'city': item.city,'state':item.state}
                    }
                ).done(function (res) {
                    if(res.status === true){
                        var data = res.data;
                        $('#state').val(data.state);
                        $('#zip').val(data.zipcode);
                    }else{
                        $('#state').val('');
                        $('#zip').val('');
                    }
                });
            }else{
                $('#city').val('');
                $('#state').val('');
                $('#zip').val('');
                $('#street_address').val('');
            }
        });

    });
</script>

@endsection
