@extends($layout)

@section('content')


<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">

    <div class="page-breadcrumb" style="padding: 0px">
        <div class="pb-2 row">
            <div class="col-5 align-self-center">
                <a href="{{ $returnArr['kembali'] }}" class="btn btn-primary">Kembali</a>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @foreach ($returnArr['breadcrumbs'] as $breadcrumb)
                                @if (!$loop->last)
                                    <li class="breadcrumb-item">
                                        <a href="{{ $breadcrumb['link'] }}" style="color: white !important;" onMouseOver="this.style.color='lightblue'" onMouseOut="this.style.color='white'"> {{ $breadcrumb['name'] }}
                                        </a>
                                    </li>
                                @else
                                <li class="breadcrumb-item active" aria-current="page" style="color: yellow !important;">
                                    {{ $breadcrumb['name'] }}
                                </li>
                                @endif
                            @endforeach

                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

  <div class="row">
      {{-- <div class="col-2"></div> --}}
      <div class="col-12">
          <div class="card">
            <div class="text-center card-header" style="background-color: #f3ce8f;"><h4>Tukar Kata Laluan</h4></div>

            <form method="POST" action="{{ route('tukar-kata-laluan.kemaskini') }}">
            {{ csrf_field() }}

              <div class="border card-body border-dark">

                  {{-- Flash Message --}}
                  @if ($message = Session::get('success'))
                    <div class="border alert alert-success border-success" style="text-align: center;">{{$message}}</div>
                  @elseif ($message = Session::get('error'))
                    <div class="border alert alert-danger border-danger" style="text-align: center;">{{$message}}</div>
                  @else
                    {{-- Hidden Gap - Just Ignore --}}
                    <div class="alert alert-white" style="text-align: center;"></div>
                    {{-- <div style="padding: 23px;"></div> --}}
                  @endif
                  <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md">
                      <label>Kata Laluan Terdahulu</label>
                      <div class="mb-3 input-group">
                          <input class="form-control @error('old_password') is-invalid @else border-dark @enderror" id="old_password" name="old_password" type="password">
                          <div class="input-group-append">
                              <button class="btn btn-secondary" type="button" id="old_password_button" onclick="visiblePassword('old_password')"><i id="old_password_icon" class="fa fa-eye-slash" aria-hidden="true"></i></button>
                          </div>
                          @error('old_password')
                          <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                      </div>
                    </div>
                    <div class="col-md-3"></div>
                  </div>

                  <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md">
                      <label>Kata Laluan Baru</label>
                      <div class="mb-3 input-group">
                          <input class="form-control @error('password') is-invalid @else border-dark @enderror" id="password" name="password" type="password">
                          <div class="input-group-append">
                              <button class="btn btn-secondary" type="button" id="password_button" onclick="visiblePassword('password')"><i id="password_icon" class="fa fa-eye-slash" aria-hidden="true"></i></button>
                          </div>
                          @error('password')
                          <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                      </div>
                    </div>
                    <div class="col-md">
                      <label>Sahkan Kata Laluan Baru</label>
                      <div class="mb-3 input-group">
                          <input class="form-control @error('password') is-invalid @else border-dark @enderror" id="password_confirmation" name="password_confirmation" type="password">
                          <div class="input-group-append">
                              <button class="btn btn-secondary" type="button" id="password_confirmation_button" onclick="visiblePassword('password_confirmation')"><i id="password_confirmation_icon" class="fa fa-eye-slash" aria-hidden="true"></i></button>
                          </div>
                          @error('password')
                          <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                      </div>
                    </div>
                    <div class="col-md-3"></div>
                  </div>

                  {{-- Submit Button --}}
                  <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6" style="text-align: center;">
                      <button type="button" class="btn waves-effect waves-light btn-info btn-block" data-toggle="modal" data-target="#confirmation">Tukar Kata laluan</button>
                    </div>
                    <div class="col-md-3"></div>
                  </div>

                  {{-- Hidden Gap - Just Ignore --}}
                  <div class="alert alert-white" style="text-align: center;"></div>
                  {{-- <div style="padding: 25px;"></div> --}}
              </div>

              <!-- Modal Confirmation -->
              <div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header" style="background-color:#f3ce8f  !important">
                      <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-exclamation-triangle" style="color:rgb(255, 255, 0)" aria-hidden="true"></i>&nbspPENGESAHAN</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body"><b>
                      Anda pasti mahu menukar kata laluan baru? </b>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-success">Tukar Kata Laluan</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
      </div>
  </div>

</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<script>
  function visiblePassword(id) {

    var x = document.getElementById(id); //fetch input id
    var y = id.concat("_button");        //fetch button id
    var z = id.concat("_icon");          // icon id

    if (x.type === "password") {
      x.type = "text";                                            //change input type
      document.getElementById(y).className = "btn btn-success";   //change button color
      document.getElementById(z).className = "fa fa-eye";         //change icon
    } else {
      x.type = "password";                                        //change input type to default
      document.getElementById(y).className = "btn btn-secondary"; //change button color to default
      document.getElementById(z).className = "fa fa-eye-slash";   //change icon to default
    }
  }
</script>
@endsection
