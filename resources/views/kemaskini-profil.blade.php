@extends('layouts.layout-ibk-nicepage')

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
            <div class="text-center card-header" style="background-color: #f3ce8f;"><h4>Kemaskini Profil</h4></div>
            <form method="POST" enctype="multipart/form-data" action="{{ route('kemaskini-profil-update') }}">
            @csrf

              <div class="border card-body border-dark">

                  {{-- Flash Message --}}
                  {{-- @if ($message = Session::get('success'))
                    <div class="border alert alert-success border-success" style="text-align: center;">{{$message}}</div>
                  @elseif ($message = Session::get('error'))
                    <div class="border alert alert-danger border-danger" style="text-align: center;">{{$message}}</div>
                  @else
                    <div class="alert alert-white" style="text-align: center;"></div>
                  @endif --}}

                  <div class="row" style="padding-top: 15px;">
                    <div class="col-md-2"></div>
                    <div class="col-md">
                      <label>Nama Pengguna</label>
                      <div class="mb-3 input-group">
                        <input readonly class="form-control  @error('name') is-invalid @else border-dark @enderror" id="name" name="name" type="text" value="{{ $user->name }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
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
                      <label>Nama Kilang</label>
                      <div class="mb-3 input-group">
                        <input readonly class="form-control  @error('name') is-invalid @else border-dark @enderror" id="name" name="name" type="text" value="{{ $info->nama_kilang }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
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
                      <label>No. SSM</label>
                      <div class="mb-3 input-group">
                        <input readonly class="form-control  @error('name') is-invalid @else border-dark @enderror" id="name" name="name" type="text" value="{{ $info->no_ssm }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
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
                      <label>No. Lesen</label>
                      <div class="mb-3 input-group">
                        <input readonly class="form-control  @error('name') is-invalid @else border-dark @enderror" id="name" name="name" type="text" value="{{ $info->no_lesen }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
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
                        <label>Jantina</label>
                        <div class="mb-3 input-group">
                            <input readonly class="form-control  @error('email') is-invalid @else border-dark @enderror" id="email" name="jantina" type="email" value="{{ $pengguna->jantina }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
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
                        <label>Warganegara</label>
                        <div class="mb-3 input-group">
                            <input readonly class="form-control  @error('email') is-invalid @else border-dark @enderror" id="email" name="email" type="email" value="{{ $pengguna->warganegara }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
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
                        <label>Kaum</label>
                        <div class="mb-3 input-group">
                            <input readonly class="form-control  @error('email') is-invalid @else border-dark @enderror" id="email" name="email" type="email" value="{{ $pengguna->kaum }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
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
                            <input readonly class="form-control  @error('ic_number') is-invalid @else border-dark @enderror" id="ic_number" name="ic_number" type="text" value="{{ $pengguna->no_kad_pengenalan }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);" maxlength="12" onkeypress="return onlyNumberKey(event)">
                          @error('ic_number')
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
                            <input class="form-control  @error('email') is-invalid @else border-dark @enderror" id="email" name="email" type="email" value="{{ $pengguna->email }}" >
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="wphoneNumber2"
                                class="">Muat Naik Gambar Hadapan Kad Pengenalan</label>

                            <input type='file' class="form-control"
                                name="gambar_ic_hadapan" id="ssm" />


                            @error('gambar_ic_hadapan')
                                <div class="alert alert-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="wphoneNumber2"
                                class="">Muat Naik Gambar Belakang Kad Pengenalan</label>
                            <input type="file" class="form-control"
                                name="gambar_ic_belakang" id="lesenkilang">
                            @error('lesen_kilang')
                                <div class="alert alert-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div> --}}

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <p>Gambar Dimuat Naik:</p>
                        <img src="{{ asset($image_path = str_replace('public', 'storage', $pengguna->gambar_ic_hadapan)) }}" alt="Sila Muatnaik Gambar Sijil SSM" id="category-img-ssm" style="width:70%;height:30vh;">
                    </div>
                    <div class="col-md-4">
                        <p>Gambar Dimuat Naik:</p>
                        <img src="{{ asset($image_path = str_replace('public', 'storage', $pengguna->gambar_ic_belakang)) }}" alt="Sila Muatnaik Gambar Lesen Kilang" id="category-img-tag-lesenkilang" style="width:70%;height:30vh;">
                    </div>
                </div>

                <br>
                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md">
                        <label>Jawatan</label>
                        <div class="mb-3 input-group">
                            <input class="form-control  @error('email') is-invalid @else border-dark @enderror"  name="jawatan"  value="{{ $pengguna->jawatan }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">

                        </div>
                    </div>

                    <div class="col-md-2"></div>
                  </div>

                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md">
                        <label>No. Pekerja</label>
                        <div class="mb-3 input-group">
                            <input class="form-control  @error('email') is-invalid @else border-dark @enderror"  name="no_pekerja"  value="{{ $pengguna->no_pekerja }}" >

                        </div>
                    </div>

                    <div class="col-md-2"></div>
                  </div>

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="form-group">



                            <label for="wphoneNumber2"
                                class="">Muat Naik Gambar
                                Berukuran Passport</label>

                                <label for="gambar_passport" class="form-control">PILIH FAIL</label>
                                <input type="file" id="gambar_passport" name="gambar_passport" accept="*" style="display: none" required title="Sila isikan butiran ini.">
                            {{-- <input type="file" class="form-control"
                                name="gambar_passport" id="lesenkilang">
                            @error('lesen_kilang')
                                <div class="alert alert-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror --}}
                        </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-3">
                        <p>Gambar Dimuat Naik:</p>
                        <img src="{{ asset($image_path = str_replace('public', 'storage', $pengguna->gambar_passport)) }}" alt="Sila Muatnaik Gambar Sijil SSM" id="category-img-ssm" style="width:70%;height:30vh;">
                    </div>
                </div>






                  {{-- <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md">
                      <label>Telefon Bimbit</label>
                      <div class="mb-3 input-group">
                        <div class="mb-3 input-group">
                            <input class="form-control  @error('mobile_phone') is-invalid @else border-dark @enderror" id="mobile_phone" name="no_telefon" type="text" value="{{ $info->no_telefon }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);" minlength="10" maxlength="11" onkeypress="return onlyNumberKey(event)">
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
                  <div class="row" style="padding-top: 35px;">
                    <div class="col-md-4"></div>
                    <div class="col-md" style="text-align: center;">
                      <button type="button" class="btn waves-effect waves-light btn-info btn-block" data-toggle="modal" data-target="#confirmation">Kemaskini Profil Pengguna</button>
                    </div>
                    <div class="col-md-4"></div>
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
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
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
</script>
@endsection
