@extends('layouts.app')
<head>
    <style>
        .create-box
        {
            background-color: rgba(221, 160, 221, 0.308);
        }
        .f-text
        {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-size: 16px;
            margin-bottom: 1px;
        }
        .form-control
        {
            margin-bottom: 5px;
        }
    </style>
</head>

@section('content')

<div class="container">

    <div class="row">
        <div class="row">
            <div class="col-lg-6  col-md-12  m-auto">
                <h2>Create new listing (99$)</h2>
            </div>
        </div>
        @if($errors->any())
        <div class="mb-4 p-4 bg-red-200 text-red-800">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div class="create-box p-3 col-lg-6 col-md-12 m-auto mt-2 rounded">
            <div class="form-box">
                <form action="{{route('listing.store')}}" method="post" id="payment_form" enctype="multipart/form-data"
                class="form">

                @guest
                    <div class="row">
                        <div class="col-6">
                            <label for="email" class="f-text">Email</label>
                            <input class="form-control" name="email" required type="email" autofocus value="{{old('email')}}">
                        </div>

                        <div class="col-6">
                            <label for="name" class="f-text">Name</label>
                            <input class="form-control" name="name" type="name" value="{{old('name')}}">
                        </div>
                        <div class="col-6">
                            <label for="password" class="f-text">Password</label>
                            <input class="form-control" name="password" required type="password" value="{{old('password')}}">
                        </div>
                        <div class="col-6">
                            <label for="password_confirmation" class="f-text">Confirm Password</label>
                            <input class="form-control" name="password_confirmation" required type="password" value="{{old('password_confirmation')}}">
                        </div>
                    </div>
                    <hr>
                @endguest
                    <div class="row">

                        <div class="col-6">
                            <label for="title" class="f-text">Job Title</label>
                            <input class="form-control" name="title" required type="text" value="{{old('title')}}">
                        </div>

                        <div class="col-6">
                            <label for="company" class="f-text">Company Name</label>
                            <input class="form-control" name="company" required type="text" value="{{old('company')}}">
                        </div>


                        <div class="col-6">
                            <label for="logo" class="f-text">Company Logo</label>
                            <input class="form-control" name="logo" required type="file" value="{{old('logo')}}">
                        </div>


                        <div class="col-6">
                            <label for="location" class="f-text">Location</label>
                            <input class="form-control" name="location" required type="text" value="{{old('location')}}">
                        </div>

                        <div class="col-12">
                            <label for="content" class="f-text">Job Content  <span class="text-muted"> (markdown is available)</span></label>
                            <textarea rows="8" class="form-control" name="content" required type="text" >{{old('content')}}</textarea>
                        </div>


                        <div class="col-6">
                            <label for="apply_link" class="f-text">Apply Link</label>
                            <input class="form-control" name="apply_link" required type="text" value="{{old('apply_link')}}">
                        </div>


                        <div class="col-6">
                            <label for="tags" class="f-text">Tags <span class="text-muted"> (seperatred by ",")</span></label>
                            <input class="form-control" name="tags" required type="text" value="{{old('tags')}}">
                        </div>


                        <div class="col-6">
                            <input name="is_highlighted" type="checkbox" >
                            <label for="tags" class="f-text"> Is highlighted ?</span></label>
                        </div>


                        <div class="my-2">
                            <div id="card-element"></div>
                        </div>

                        <div class="mt-2">
                            @csrf
                            <input
                                type="hidden"
                                id="payment_method_id"
                                name="payment_method_id"
                                value="">
                            <button type="submit" id="form_submit" class="btn btn-lg btn-outline-dark col-12">Pay + Continue</button>
                        </div>



                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://js.stripe.com/v3/"></script>
<script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card', {
            classes: {
                base: 'StripeElement rounded-md shadow-sm bg-white px-2 py-3'
            }
        });

        cardElement.mount('#card-element');

        document.getElementById('form_submit').addEventListener('click', async (e) => {
            // prevent the submission of the form immediately
            e.preventDefault();

            const { paymentMethod, error } = await stripe.createPaymentMethod(
                'card', cardElement, {}
            );

            if (error) {
                alert(error.message);
            } else {
                // card is ok, create payment method id and submit form
                document.getElementById('payment_method_id').value = paymentMethod.id;
                document.getElementById('payment_form').submit();
            }
        })
</script>



@endsection
