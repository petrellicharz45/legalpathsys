@extends('layouts.client.layout')
@section('title')
<title>{{ $navigation->register }}</title>
@endsection
@section('client-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->login ? url($banner->login) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $navigation->register }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><span>{{ $navigation->register }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Register Start-->
<div class="register-area pt_70 pb_70">
	<div class="container wow fadeIn">
		<div class="row">
            @if ($setting->text_direction=='RTL')
            <div class="col-lg-3"></div>
            @endif
			<div class="offset-lg-3 col-lg-6 offset-lg-3">
				<div class="regiser-form login-form">
					<form action="{{ route('register') }}" method="POST">
                        @csrf
						<div class="form-row row">
							<div class="form-group col-12">
								<label for="name">{{ $website_lang->where('lang_key','name')->first()->custom_lang }}</label>
								<input name="name" type="text" id="name" class="form-control" value="{{ old('name') }}">
							</div>

							  <div class="form-group col-12">
                                <div class="form-group">
                                    <label for="show_homepage">Account Type *</label>
                                    <select name="account_type" id="account_type" class="form-control" onchange="yesnoCheck(this);">
                                        <option value="Client">Client</option>
                                        <option value="Student">Student</option>
                                    </select>
                                </div>
                            </div>
                            <div id="others" class="form-group col-12" style="display: none;">

                             <div class="form-group col-12">
                                <div class="form-group">
                                    <label for="show_homepage">University *</label>
                                    <select name="university" id="university" class="form-control">
                                        <option value="University">University</option>
                                        <option value="Makerere">Makerere</option>
                                    </select>
                                </div>
                            </div>


                            	<div class="form-group col-12">
								<label for="email">Student Registration No</label>
								<input type="text" name="studentreg_no" id="studentreg_no" class="form-control" value="{{ old('studentreg_no') }}">
							</div>

								<div class="form-group col-12">
								<label for="email">Studen Id</label>
								<input type="text" name="student_id" id="student_id" class="form-control" value="{{ old('student_id') }}">
							</div>
							</div>

							<div class="form-group col-12">
								<label for="email">{{ $website_lang->where('lang_key','email')->first()->custom_lang }}</label>
								<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
							</div>
							<div class="form-group col-12">
								<label for="password">{{ $website_lang->where('lang_key','password')->first()->custom_lang }}</label>
								<input type="password" name="password" class="form-control" id="password">
							</div>
                            @if ($setting->allow_captcha==1)
                            <div class="form-group col-12">
                                <div class="g-recaptcha" data-sitekey="{{ $setting->captcha_key }}"></div>
                            </div>
                            @endif
							<div class="form-group col-12">
								<button type="submit" class="btn btn-primary">{{ $website_lang->where('lang_key','registration')->first()->custom_lang }}</button>
							</div>
						</div>
					</form>

					<a href="{{ url('login') }}" class="link">{{ $website_lang->where('lang_key','login_here')->first()->custom_lang }}</a>

				</div>
			</div>
		</div>
	</div>
</div>
<!--Register End-->

@endsection
<script type="text/javascript">
	function yesnoCheck(that) {
    if (that.value == "student") {

        document.getElementById("others").style.display = "block";
    } else {
        document.getElementById("others").style.display = "none";
    }
}

</script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery.ui.min.js"></script>
