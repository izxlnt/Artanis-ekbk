

@extends('layouts.app')
@section('content')

<style>
body {
	margin:0;
	display:flex;
	justify-content:center;
	align-items:center;

}
.captcha {
  /* margin:20px; */
	background-color:#f9f9f9;
	/* border:2px solid #d3d3d3; */
	border-radius:5px;
	color:#4c4a4b;
	display:flex;
	justify-content:center;
	align-items:center;
}

@media screen and (max-width: 500px) {
	.captcha {
		flex-direction:column;
	}
	.text {
		margin:.5em!important;
		text-align:center;
	}
	.logo {
		align-self: center!important;
	}
	.spinner {
		margin:2em .5em .5em .5em!important;
	}
}

.text {
	/* font-size:1.75em; */
	/* font-weight:500; */
	margin-right:1em;
}
.spinner {
	position:relative;
	width:2em;
	height:2em;
	display:flex;
	margin:2em 1em;
	align-items:center;
	justify-content:center;
}
input[type="checkbox"] { position: absolute; opacity: 0; z-index: -1; }
input[type="checkbox"]+.checkmark {
	display:inline-block;
	width:2em;
	height:2em;
	background-color:#fcfcfc;
	border:2.5px solid #c3c3c3;
	border-radius:3px;
	display:flex;
	justify-content:center;
	align-items:center;
	cursor: pointer;
}
input[type="checkbox"]+.checkmark span {
	content:'';
	position:relative;/*
	position:absolute;
	border-bottom:3px solid;
	border-right:3px solid;
	border-color:#029f56;*/
	margin-top:-3px;
	transform:rotate(45deg);
	width:.75em;
	height:1.2em;
	opacity:0;
}
input[type="checkbox"]+.checkmark>span:after {
	content:'';
	position:absolute;
	display:block;
	height:3px;
	bottom:0;left:0;
	background-color:#029f56;
}
input[type="checkbox"]+.checkmark>span:before {
	content:'';
	position:absolute;
	display:block;
	width:3px;
	bottom:0;right:0;
	background-color:#029f56;
}
input[type="checkbox"]:checked+.checkmark {
	animation:2s spin forwards;
}
input[type="checkbox"]:checked+.checkmark>span {
	animation:1s fadein 1.9s forwards;
}
input[type="checkbox"]:checked+.checkmark>span:after {animation:.3s bottomslide 2s forwards;}
input[type="checkbox"]:checked+.checkmark>span:before {animation:.5s rightslide 2.2s forwards;}
@keyframes fadein {
	0% {opacity:0;}
	100% {opacity:1;}
}
@keyframes bottomslide {
	0% {width:0;}
	100% {width:100%;}
}
@keyframes rightslide {
	0% {height:0;}
	100% {height:100%;}
}
.logo {
	display:flex;
	flex-direction:column;
	align-items:center;
	height:100%;
	align-self:flex-end;
	margin:0.5em 1em;
}
.logo img {
	height:2em;
	width:2em;
}
.logo p {
	color:#9d9ba7;
	margin:0;
	/* font-size:1em; */
	/* font-weight:700; */
	margin:.4em 0 .2em 0;
}
.logo small {
	color:#9d9ba7;
	margin:0;
	font-size:.8em;
}
@keyframes spin {
	10% {
		width:0;
		height:0;
		border-width:6px;
	}
	30% {
		width:0;
		height:0;
		border-radius:50%;
		border-width:1em;
		transform: rotate(0deg);
		border-color:rgb(199,218,245);
	}
	50% {
		width:2em;
		height:2em;
		border-radius:50%;
		border-width:4px;
		border-color:rgb(199,218,245);
		border-right-color:rgb(89,152,239);
	}
	70% {
		border-width:4px;
		border-color:rgb(199,218,245);
		border-right-color:rgb(89,152,239);
	}
	90% {
		border-width:4px;
	}
	100% {
		width:2em;
		height:2em;
		border-radius:50%;
		transform: rotate(720deg);
		border-color:transparent;
	}
}
::selection {
	background-color:transparent;
	color:teal;
}
::-moz-selection {
	background-color:transparent;
	color:teal;
}
.desg-name{
  color:red;
font-weight:bold;
font-size:20px;
}
</style>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center" >
				<div class="col-md-12 col-lg">
					<div class="d-md-flex">
						<div class="p-1 text-center text-wrap p-lg-5 d-flex align-items-center" style="background: linear-gradient(135deg, #2691e2 0%, #47e5e8 100%);">
							<div class="text w-200">
								<h1>Selamat Datang Ke Sistem e-KBK <BR> (KILANG BERASAS KAYU)</h1>
                                <br>
                                <h2>Daftar Masuk</h2>
							</div>
			      </div>
					<div class="p-4 login-wrap p-lg-5">
						{{-- Flash Message --}}
						@if ($message = Session::get('success'))
							<div class="border alert alert-success border-success" style="text-align: center;">{{$message}}</div>
						@elseif ($message = Session::get('error'))
							<div class="border alert alert-danger border-danger" style="text-align: center;">{{$message}}</div>
						@else

						@endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                              <div class="card-body">
                                <div style="text-align:center;">
                                <label>Maklumat Peribadi</label>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                      <label>ID Pengguna</label>
                                        <div class="mb-3 input-group">
                                            <input name="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required autofocus placeholder="ID Pengguna" value="{{ old('name') }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                                                    @if($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ strtoupper($errors->first('name')) }}
                                                        </div>
                                                    @endif
                                        </div>
                                    </div>
                                  </div>

                                <div class="row">
                                    <div class="col-md">
                                      <label>Kata Laluan</label>
                                      <div class="mb-3 input-group">
                                        <div class="mb-3 input-group">
                                            <input name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" value="1234567890" required placeholder="Kata Laluan">
                                            @if($errors->has('password'))
                                                <div class="invalid-feedback">
                                                    {{ strtoupper($errors->first('password')) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-md">
                                        <label>Sahkan Kata Laluan</label>
                                        <div class="mb-3 input-group">
                                          <div class="mb-3 input-group">
                                              <input name="password_confirmation" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" value="1234567890" required placeholder="Sahkan Kata Laluan">
                                                      @if($errors->has('password'))
                                                          <div class="invalid-feedback">
                                                              {{ strtoupper($errors->first('password')) }}
                                                          </div>
                                                      @endif
                                          </div>
                                      </div>
                                      </div>
                                  </div>

                                  <hr>

                                  <div class="row">
                                    <div class="col-md">
                                      <label>Nama</label>
                                        <div class="mb-3 input-group">
                                            <input name="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required autofocus placeholder="Nama" value="{{ old('name') }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                                                    @if($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ strtoupper($errors->first('name')) }}
                                                        </div>
                                                    @endif
                                        </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-md">
                                        <label>Kad Pengenalan</label>
                                        <div class="mb-3 input-group">
                                            <input name="ic_number" type="text" class="form-control{{ $errors->has('ic_number') ? ' is-invalid' : '' }}" required autofocus placeholder="Kad Pengenalan" value="{{ old('ic_number') }}" minlength="12" maxlength="12" onkeypress="return onlyNumberKey(event)">
                                            @if($errors->has('ic_number'))
                                                <div class="invalid-feedback">
                                                    {{ strtoupper($errors->first('ic_number')) }}
                                                </div>
                                            @endif
                                        </div>
                                      </div>
                                  </div>

                                  {{-- <div class="row">
                                    <div class="col-md">
                                      <label>Syarikat</label>
                                        <div class="mb-3 input-group">
                                            <input name="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required autofocus placeholder="Syarikat" value="{{ old('name') }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                                                    @if($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ strtoupper($errors->first('name')) }}
                                                        </div>
                                                    @endif
                                        </div>
                                    </div>
                                  </div> --}}

                                  {{-- <div class="row">
                                    <div class="col-md">
                                      <label>Jenis Pelanggan</label>
                                        <div class="mb-3 input-group">
																					<select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                            <option selected="">Sila Pilih</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                                    @if($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ strtoupper($errors->first('name')) }}
                                                        </div>
                                                    @endif
                                        </div>
                                    </div>
                                  </div> --}}

                                  {{-- <div class="row">
                                    <div class="col-md">
                                      <label>Pekerjaan</label>
                                        <div class="mb-3 input-group">
                                            <input name="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required autofocus placeholder="Pekerjaan" value="{{ old('name') }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                                                    @if($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ strtoupper($errors->first('name')) }}
                                                        </div>
                                                    @endif
                                        </div>
                                    </div>
                                  </div> --}}

                                  <hr>


                                  <div class="row">
                                    <div class="col-md">
                                        <label>Alamat</label>
                                        <div class="mb-3 input-group">
                                            <textarea class="form-control" rows="3" placeholder="Alamat"></textarea>
                                            @if($errors->has('email'))
                                                <div class="invalid-feedback">
                                                    {{ strtoupper($errors->first('email')) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                  </div>

                                  <div class="row">
                                    <div class="col-md">
                                        <label>Poskod</label>
                                        <div class="mb-3 input-group">
                                            <input name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autofocus placeholder="Poskod" value="{{ old('email') }}">
                                            @if($errors->has('email'))
                                                <div class="invalid-feedback">
                                                    {{ strtoupper($errors->first('email')) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                  </div>

                                  {{-- <div class="row">
                                    <div class="col-md">
                                        <label>Negara</label>
                                        <div class="mb-3 input-group">
																					<select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                            <option selected="">Sila Pilih</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                            @if($errors->has('email'))
                                                <div class="invalid-feedback">
                                                    {{ strtoupper($errors->first('email')) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                  </div> --}}

                                  {{-- <div class="row">
                                    <div class="col-md">
                                        <label>Negeri</label>
                                        <div class="mb-3 input-group">
																					<select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                            <option selected="">Sila Pilih</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                            @if($errors->has('email'))
                                                <div class="invalid-feedback">
                                                    {{ strtoupper($errors->first('email')) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                  </div> --}}

                                  {{-- <div class="row">
                                    <div class="col-md">
                                      <label>Telefon Bimbit</label>
                                      <div class="mb-3 input-group">
                                        <div class="mb-3 input-group">
                                            <input name="mobile_phone" type="text" class="form-control{{ $errors->has('mobile_phone') ? ' is-invalid' : '' }}" required autofocus placeholder="Nombor Telefon Bimbit" value="{{ old('mobile_phone') }}">
                                            @if($errors->has('address'))
                                                <div class="invalid-feedback">
                                                    {{ strtoupper($errors->first('address')) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    </div>


                                  </div> --}}

                                  <div class="row">
                                    <div class="col-md">
                                        <label>Emel</label>
                                        <div class="mb-3 input-group">
                                            <input name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autofocus placeholder="Emel" value="{{ old('email') }}">
                                            @if($errors->has('email'))
                                                <div class="invalid-feedback">
                                                    {{ strtoupper($errors->first('email')) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                  </div>

																	{{-- <div class="row">
                                    <div class="col-md">
																			<div class="captcha">
																			<div class="spinner">
																				<label>
																					<input type="checkbox" onclick="$(this).attr('disabled','disabled');">
																					<span class="checkmark"><span>&nbsp;</span></span>
																				</label>
																			</div>
																			<div class="text">
																				I'm not a robot
																			</div>
																			<div class="logo">
																				<img src="https://forum.nox.tv/core/index.php?media/9-recaptcha-png/"/>
																				<p>reCAPTCHA</p>
																				<small>Privacy - Terms</small>
																			</div>
																			</div>
                                    </div>


                                  </div> --}}

                                  {{-- Submit Button --}}
                                  <div class="row" style="padding-top: 15px;">
                                    <div class="col-md" style="text-align: center;">
                                        <div class="form-group">
                                            <button type="submit" class="px-3 form-control btn btn-primary submit">Daftar</button>
                                        </div>
                                        <div class="form-group d-md-flex">
                                            <div class="w-100 text-md-center">
                                                <a href="{{ route('login') }}"> Sudah mempunyai akaun? Log Masuk Disini.</a>
                                            </div>
                                        </div>
                                    </div>

                                  </div>

                                  {{-- Hidden Gap - Just Ignore --}}
                                  <div class="alert alert-white" style="text-align: center;"></div>
                                  {{-- <div style="padding: 25px;"></div> --}}
                              </div>

                            </form>
		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>


	</body>

    <script>
        function onlyNumberKey(evt) {

              // Only ASCII charactar in that range allowed
              var ASCIICode = (evt.which) ? evt.which : evt.keyCode
              if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                  return false;
              return true;
        }
      </script>
@endsection
