<h5><b>3.{{ __('Course description') }}</b></h5>
<!-----------------------------------3. Mô tả môn học--------------------------->
<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMoTa">
    <i class="fas fa-edit"></i>
</button> <br> --}}
{!! $hocPhan->moTaHocPhan !!}
<!-- /////////////////////Modal thêm mô tả học phần-->
<div class="modal fade" id="addMoTa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ asset('/giang-vien/bien-soan-de-cuong/sua_mo_ta_mon_hoc') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Course description') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                    </div>
                    <div class="form-group">
                        <textarea name="moTaHocPhan" id="moTa" cols="30" rows="10" class="form-control" required>
                              {{ $hocPhan->moTaHocPhan }}
                            </textarea>
                        <script>
                            CKEDITOR.replace('moTa', {
                                filebrowserUploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
                                filebrowserUploadMethod: 'form'
                            });

                        </script>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
