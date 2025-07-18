@extends('layouts.layout-phd-nicepage')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">

  <div class="row">
      {{-- <div class="col-2"></div> --}}
      <div class="col-12">

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


          <div class="card">
            <form method="POST" enctype="multipart/form-data" action="{{ route('phd.kemaskini-profil-update') }}">
            @csrf

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
                    <div class="col-md-2"></div>
                    <div class="col-md">
                      <label>Nama Pengguna</label>
                      <div class="mb-3 input-group">
                        <input readonly class="form-control text-uppercase @error('name') is-invalid @else border-dark @enderror" id="name" name="name" type="text" value="{{ $user->name }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    </div>
                    <div class="col-md-2"></div>
                  </div>

                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md">
                        <label>Negeri</label>
                        <div class="mb-3 input-group">
                            <input readonly class="form-control text-uppercase @error('email') is-invalid @else border-dark @enderror" id="email" name="jantina" type="email" value="{{ $user->negeri }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                          @error('email')
                          <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                    </div>

                    <div class="col-md-2"></div>
                  </div>

                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md">
                        <label>No. Kad Pengenalan</label>
                        <div class="mb-3 input-group">
                            <input readonly class="form-control text-uppercase @error('email') is-invalid @else border-dark @enderror" id="email" name="jantina" type="email" value="{{ $user->login_id }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                          @error('email')
                          <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                    </div>

                    <div class="col-md-2"></div>
                  </div>
                  @if($user->kategori_pengguna == 'PHD')
                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md">
                        <label>Daerah</label>
                        <div class="mb-3 input-group">
                            <input readonly class="form-control text-uppercase @error('email') is-invalid @else border-dark @enderror" id="email" name="jantina" type="email" value="{{ $user->daerah }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                          @error('email')
                          <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                    </div>

                    <div class="col-md-2"></div>
                  </div>
                  @else
                  @endif

                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md">
                        <label>Jawatan</label>
                        <div class="mb-3 input-group">
                            <input  readonly class="form-control text-uppercase @error('email') is-invalid @else border-dark @enderror" id="email" name="jawatan"  value="{{ $user->jawatan }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                          @error('email')
                          <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                    </div>

                    <div class="col-md-2"></div>
                  </div>

                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md">
                        <label>Emel</label>
                        <div class="mb-3 input-group">
                            <input  class="form-control @error('email') is-invalid @else border-dark @enderror" id="email" name="email" type="email" value="{{ $user->email }}" 
                                    oninput="validateEmail(this)">
                            <div id="email-validation-message" class="invalid-feedback"></div>
                          @error('email')
                          <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                    </div>

                    <div class="col-md-2"></div>
                  </div>








                  {{-- <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md">
                      <label>Telefon Bimbit</label>
                      <div class="mb-3 input-group">
                        <div class="mb-3 input-group">
                            <input class="form-control text-uppercase @error('mobile_phone') is-invalid @else border-dark @enderror" id="mobile_phone" name="no_telefon" type="text" value="{{ $info->no_telefon }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);" minlength="10" maxlength="11" onkeypress="return onlyNumberKey(event)">
                          @error('mobile_phone')
                          <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                    </div>
                    </div>

                    <div class="col-md-2"></div>
                  </div> --}}

                  {{-- Submit Button --}}
                  <div class="row" style="padding-top: 15px;">
                    <div class="col-md-2"></div>
                    <div class="col-md" style="text-align: center;">
                      <button type="button" class="btn waves-effect waves-light btn-info btn-block" data-toggle="modal" data-target="#confirmation">Kemaskini Profil Pengguna</button>
                    </div>
                    <div class="col-md-2"></div>
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
                      <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="color:rgb(255, 255, 0)"></i>&nbspPENGESAHAN</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body"><b>
                      Anda pasti mahu mengemaskini profil pengguna?</b>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-success">Kemaskini Profil Pengguna</button>
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
  function onlyNumberKey(evt) {

        // Only ASCII charactar in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
  }
  
  function validateEmail(input) {
      const email = input.value;
      const messageDiv = document.getElementById('email-validation-message');
      
      // Clear previous validation
      input.classList.remove('is-invalid', 'is-valid');
      messageDiv.textContent = '';
      
      if (!email) {
          return;
      }
      
      // Basic email format validation
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email)) {
          input.classList.add('is-invalid');
          messageDiv.textContent = 'Format emel tidak sah.';
          return;
      }
      
      // Check email uniqueness via AJAX
      fetch('/email/check-unique', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ email: email })
      })
      .then(response => response.json())
      .then(data => {
          if (data.unique) {
              input.classList.add('is-valid');
              messageDiv.textContent = '';
          } else {
              input.classList.add('is-invalid');
              messageDiv.textContent = 'Emel ini telah digunakan.';
          }
      })
      .catch(error => {
          console.error('Error checking email:', error);
      });
  }
</script>
@endsection
