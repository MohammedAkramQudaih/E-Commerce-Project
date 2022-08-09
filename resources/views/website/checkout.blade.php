@extends('website.master')
@section('content')

    <!-- BREADCRUMB -->
    {{-- <div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<h3 class="breadcrumb-header">Checkout</h3>
						<ul class="breadcrumb-tree">
							<li><a href="#">Home</a></li>
							<li class="active">Checkout</li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div> --}}
    <!-- /BREADCRUMB -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <div class="col-md-7">
                    <h2 class="mb-5">Make Your Checkout Here</h2>
                    <link type="text/css" rel="stylesheet" href="{{ asset('paymentstyle/style.css') }}" />
                    {{-- <link type="text/css" rel="stylesheet" href="{{ asset('paymentstyle/normalize.css') }}" /> --}}


                    <form id="payment-form" method="POST" action="https://merchant.com/charge-card">
                        <div class="one-liner">
                            <div class="card-frame"></div>
                            <button id="pay-button" disabled>
                                PAY GBP 24.99
                            </button>
                        </div>
                        <p class="error-message"></p>
                        <p class="success-payment-message"></p>
                    </form>

                    <script src="https://cdn.checkout.com/js/framesv2.min.js"></script>
                    {{-- <script src="{{ asset('paymentstyle/app.js') }}"></script> --}}
                    <script>
                        /* global Frames */
                        var payButton = document.getElementById("pay-button");
                        var form = document.getElementById("payment-form");

                        // Frames.init("pk_test_8ac41c0d-fbcc-4ae3-a771-31ea533a2beb");
                        Frames.init("pk_sbox_xqonhaeaxju7tibqboz6vsb57yb");


                        var logos = generateLogos();

                        function generateLogos() {
                            var logos = {};
                            logos["card-number"] = {
                                src: "card",
                                alt: "card number logo",
                            };
                            logos["expiry-date"] = {
                                src: "exp-date",
                                alt: "expiry date logo",
                            };
                            logos["cvv"] = {
                                src: "cvv",
                                alt: "cvv logo",
                            };
                            return logos;
                        }

                        var errors = {};
                        errors["card-number"] = "Please enter a valid card number";
                        errors["expiry-date"] = "Please enter a valid expiry date";
                        errors["cvv"] = "Please enter a valid cvv code";

                        Frames.addEventHandler(
                            Frames.Events.FRAME_VALIDATION_CHANGED,
                            onValidationChanged
                        );

                        function onValidationChanged(event) {
                            var e = event.element;

                            if (event.isValid || event.isEmpty) {
                                if (e === "card-number" && !event.isEmpty) {
                                    showPaymentMethodIcon();
                                }
                                setDefaultIcon(e);
                                clearErrorIcon(e);
                                clearErrorMessage(e);
                            } else {
                                if (e === "card-number") {
                                    clearPaymentMethodIcon();
                                }
                                setDefaultErrorIcon(e);
                                setErrorIcon(e);
                                setErrorMessage(e);
                            }
                        }

                        function clearErrorMessage(el) {
                            var selector = ".error-message__" + el;
                            var message = document.querySelector(selector);
                            // message.textContent = "";
                        }

                        function clearErrorIcon(el) {
                            var logo = document.getElementById("icon-" + el + "-error");
                            // logo.style.removeProperty("display");
                        }

                        function showPaymentMethodIcon(parent, pm) {
                            if (parent) parent.classList.add("show");

                            var logo = document.getElementById("logo-payment-method");
                            if (pm) {
                                var name = pm.toLowerCase();
                                // logo.setAttribute("src", "images/card-icons/" + name + ".svg");
                                // logo.setAttribute("alt", pm || "payment method");
                            }
                            // logo.style.removeProperty("display");
                        }

                        function clearPaymentMethodIcon(parent) {
                            if (parent) parent.classList.remove("show");

                            var logo = document.getElementById("logo-payment-method");
                            // logo.style.setProperty("display", "none");
                        }

                        function setErrorMessage(el) {
                            var selector = ".error-message__" + el;
                            var message = document.querySelector(selector);
                            // message.textContent = errors[el];
                        }

                        function setDefaultIcon(el) {
                            var selector = "icon-" + el;
                            var logo = document.getElementById(selector);
                            // logo.setAttribute("src", "images/card-icons/" + logos[el].src + ".svg");
                            // logo.setAttribute("alt", logos[el].alt);
                        }

                        function setDefaultErrorIcon(el) {
                            var selector = "icon-" + el;
                            var logo = document.getElementById(selector);
                            // logo.setAttribute("src", "images/card-icons/" + logos[el].src + "-error.svg");
                            // logo.setAttribute("alt", logos[el].alt);
                        }

                        function setErrorIcon(el) {
                            var logo = document.getElementById("icon-" + el + "-error");
                            // logo.style.setProperty("display", "block");
                        }

                        Frames.addEventHandler(
                            Frames.Events.CARD_VALIDATION_CHANGED,
                            cardValidationChanged
                        );

                        function cardValidationChanged() {
                            payButton.disabled = !Frames.isCardValid();
                        }

                        Frames.addEventHandler(
                            Frames.Events.CARD_TOKENIZATION_FAILED,
                            onCardTokenizationFailed
                        );

                        function onCardTokenizationFailed(error) {
                            console.log("CARD_TOKENIZATION_FAILED: %o", error);
                            Frames.enableSubmitForm();
                        }

                        Frames.addEventHandler(Frames.Events.CARD_TOKENIZED, onCardTokenized);

                        function onCardTokenized(event) {
                            var el = document.querySelector(".success-payment-message");
                            // el.innerHTML =
                            //   "Card tokenization completed<br>" +
                            //   'Your card token is: <span class="token">' +
                            //   event.token +
                            //   "</span>";


                            $.ajax({
                                type: 'post',
                                url: '{{ route('website.payment') }}',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    token: event.token
                                },
                                success: function() {
                                    // window.location.href = data;
                                    console.log('Done');
                                }
                            });
                        }

                        Frames.addEventHandler(
                            Frames.Events.PAYMENT_METHOD_CHANGED,
                            paymentMethodChanged
                        );

                        function paymentMethodChanged(event) {
                            var pm = event.paymentMethod;
                            let container = document.querySelector(".icon-container.payment-method");

                            if (!pm) {
                                clearPaymentMethodIcon(container);
                            } else {
                                clearErrorIcon("card-number");
                                showPaymentMethodIcon(container, pm);
                            }
                        }

                        form.addEventListener("submit", onSubmit);

                        function onSubmit(event) {
                            event.preventDefault();
                            Frames.submitCard();
                        }
                    </script>




                </div>

                <!-- Order Details -->
                <div class="col-md-5 order-details">
                    <div class="section-title text-center">
                        <h3 class="title">Your Order</h3>
                    </div>
                    <div class="order-summary">
                        <div class="order-col">
                            <div><strong>PRODUCT</strong></div>
                            <div><strong>TOTAL</strong></div>
                        </div>
                        <div class="order-products">
                            <div class="order-col">
                                <div>1x Product Name Goes Here</div>
                                <div>$980.00</div>
                            </div>
                            <div class="order-col">
                                <div>2x Product Name Goes Here</div>
                                <div>$980.00</div>
                            </div>
                        </div>
                        <div class="order-col">
                            <div>Shiping</div>
                            <div><strong>FREE</strong></div>
                        </div>
                        <div class="order-col">
                            <div><strong>TOTAL</strong></div>
                            <div><strong class="order-total">$2940.00</strong></div>
                        </div>
                    </div>
                    <div class="payment-method">
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-1">
                            <label for="payment-1">
                                <span></span>
                                Direct Bank Transfer
                            </label>
                            <div class="caption">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-2">
                            <label for="payment-2">
                                <span></span>
                                Cheque Payment
                            </label>
                            <div class="caption">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-3">
                            <label for="payment-3">
                                <span></span>
                                Paypal System
                            </label>
                            <div class="caption">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                    <div class="input-checkbox">
                        <input type="checkbox" id="terms">
                        <label for="terms">
                            <span></span>
                            I've read and accept the <a href="#">terms & conditions</a>
                        </label>
                    </div>
                    <a href="#" class="primary-btn order-submit">Place order</a>
                </div>
                <!-- /Order Details -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
@stop
