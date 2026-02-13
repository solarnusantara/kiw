@extends('backend.layouts.app')

@section('content')

    <div class="row">
        {{-- Xendit --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6 ">{{ translate('Xendit Credential') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Activation') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="updateSettings(this, 'xendit_payment')"
                                        @if (get_setting('xendit_payment') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="XENDIT_ACCESS_TOKEN">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Xendit Access Token') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="XENDIT_ACCESS_TOKEN"
                                    value="{{ env('XENDIT_ACCESS_TOKEN') }}"
                                    placeholder="{{ translate('Xendit Access Token') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="XENDIT_PUBLIC_KEY">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Xendit Public Key') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="XENDIT_PUBLIC_KEY"
                                    value="{{ env('XENDIT_PUBLIC_KEY') }}"
                                    placeholder="{{ translate('Xendit Public Key') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Xendit Sandbox Mode') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input value="1" name="xendit_sandbox" type="checkbox"
                                        onchange="updateSettings(this, 'xendit_sandbox')" @if (get_setting('xendit_sandbox') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Paypal --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6 ">{{ translate('Paypal Credential') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Activation') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="updateSettings(this, 'paypal_payment')"
                                        @if (get_setting('paypal_payment') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="PAYPAL_CLIENT_ID">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Paypal Client Id') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="PAYPAL_CLIENT_ID"
                                    value="{{ env('PAYPAL_CLIENT_ID') }}"
                                    placeholder="{{ translate('Paypal Client ID') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="PAYPAL_CLIENT_SECRET">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Paypal Client Secret') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="PAYPAL_CLIENT_SECRET"
                                    value="{{ env('PAYPAL_CLIENT_SECRET') }}"
                                    placeholder="{{ translate('Paypal Client Secret') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Paypal Sandbox Mode') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input value="1" name="paypal_sandbox" type="checkbox"
                                        onchange="updateSettings(this, 'paypal_sandbox')" @if (get_setting('paypal_sandbox') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Stripe --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6 ">{{ translate('Stripe Credential') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Activation') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="updateSettings(this, 'stripe_payment')"
                                        @if (get_setting('stripe_payment') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="STRIPE_KEY">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Stripe Key') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="STRIPE_KEY"
                                    value="{{ env('STRIPE_KEY') }}" placeholder="{{ translate('STRIPE KEY') }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="STRIPE_SECRET">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Stripe Secret') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="STRIPE_SECRET"
                                    value="{{ env('STRIPE_SECRET') }}" placeholder="{{ translate('STRIPE SECRET') }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function updateSettings(el, type) {
            if ($(el).is(':checked')) {
                var value = 1;
            } else {
                var value = 0;
            }
            $.post('{{ route('settings.update.activation') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                value: value
            }, function(data) {
                if (data == '1') {
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
