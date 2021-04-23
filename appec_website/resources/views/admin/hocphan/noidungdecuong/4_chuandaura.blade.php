<h5><b>4.{{ __('Course learning outcomes') }}</b></h5>    <!-----------------------------------4. chuẩn đầu ra của môn học--------------------------->
<table class="table table-bordered">
  <thead>
      <th colspan="2"></th>
      <th style="background-color: green">{{ __('Satisfy LOs of the program') }}</th> 
      <th style="background-color: green">{{ __('Satisfy Abet') }}</th> 
      <th style="background-color: green">{{ __('Option') }}</th>                     
  </thead>
  <tbody>
     @foreach ($CDR1 as $cdr1)
        <tr>
          <td colspan="3"><b>{{ __('Topic') }} {{ $cdr1->maCDR1VB }}: {{ $cdr1->tenCDR1 }}:</b> 
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#chuDe_{{ $cdr1->maCDR1VB }}">
              <i class="fas fa-edit"></i>
            </button>

            <!-- /////////////////// Modal them noi dung mon hoc-->
            <div class="modal fade" id="chuDe_{{ $cdr1->maCDR1VB }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/them_chuan_dau_ra_mon_hoc') }}" method="post">
                @csrf
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Topic') }} {{ $cdr1->maCDR1VB }}: {{ $cdr1->tenCDR1 }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                    </div>
                    <div class="form-group">
                        <label for=""> {{ _('Studying results ID') }}:</label>
                        <input type="text" name="maKQHTVB" placeholder="" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for=""> {{ __('studying results content') }}:</label>
                      <input type="text" name="tenKQHT" placeholder="" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for=""> {{ __('Level-3 outcome') }}:</label>
                      <select name="maCDR3[]" id="" class="form-control" multiple>
                        @foreach ($cdr as $t)
                            @if ($t->maCDR1==$cdr1->maCDR1)
                                <option value="{{ $t->maCDR3 }}"> {{ $t->maCDR3VB }} - {{ $t->tenCDR3 }}</option>
                            @endif
                            @if ($cdr1->maCDR1=='1' && $t->maCDR1=='4')
                                <option value="{{ $t->maCDR3 }}"> {{ $t->maCDR3VB }} - {{ $t->tenCDR3 }}</option> 
                            @endif
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group">
                      <select name="maChuanAbet" id="" class="form-control">
                        @foreach ($chuan_abet as $abet)
                            <option value="{{ $abet->maChuanAbet }}">{{ $abet->maChuanAbetVB}}--{{ $abet->tenChuanAbet }}</option>
                        @endforeach
                        
                      </select>
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
          </td>
        </tr>
        @php
              $cur_rs=0;
              $bienchay=0;
        @endphp
        @foreach ($kqht as $x)
            @if ($x->maCDR1==$cdr1->maCDR1)
            
              @php
                  $rs=$kqht->where('maCDR1',$cdr1->maCDR1)->where('maKQHT',$x->maKQHT)->count(); 
                  
                  if($bienchay>=$rs || $rs>$cur_rs){
                    $cur_rs=$rs;  
                    $bienchay=1;
                  }
                  else {
                     $bienchay+=1;
                  }
              @endphp
         
              @if($bienchay==1)
                <tr>
                  <td rowspan={{ $rs }}>{{ $x->maKQHTVB }}</td>
                  <td rowspan={{ $rs }}>{{ $x->tenKQHT }}</td>
                  <td>{{ $x->maCDR3VB }}</td>
                  <td>{{ $x->maChuanAbetVB }}</td>
                  <td>
                    
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editKQHT_HP_{{ $x->id }}">
                      <i class="fas fa-edit"></i>
                    </button>
                  </td>
                </tr>   
              @else
                <tr>
                  <td>{{ $x->maCDR3VB }}</td>
                  <td>{{ $x->maChuanAbetVB }}</td>
                  <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editKQHT_HP_{{ $x->id }}">
                      <i class="fas fa-edit"></i>
                    </button>
                  </td>
                </tr>
              @endif
            <!-- Modal editing outcome-->
            <div class="modal fade" id="editKQHT_HP_{{ $x->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <form action="{{ asset('/quan-ly/hoc-phan/de-cuong-mon-hoc/sua_chuan_dau_ra_mon_hoc') }}" method="post">
            @csrf
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Editing outcomes</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <input type="text" name="id" value="{{ $x->id }}" hidden>
                  </div>
                  <div class="form-group">
                    <input type="text" name="maKQHT" value="{{ $x->maKQHT }}" hidden>
                  </div>
                  <div class="form-group">
                    <input type="text" name="maHocPhan" value="{{ $hocPhan->maHocPhan }}" hidden>
                  </div>
                  <div class="form-group">
                      <label for=""> {{ _('Studying results ID') }}:</label>
                      <input type="text" name="maKQHTVB" placeholder="L1,L2,..." class="form-control" value="{{ $x->maKQHTVB }}">
                  </div>
                  <div class="form-group">
                    <label for=""> {{ __('studying results content') }}:</label>
                    <input type="text" name="tenKQHT" placeholder="Ph�n t�ch, kh�i ni&#7879;m, m� t&#7843;,..." class="form-control" value="{{ $x->tenKQHT }}">
                  </div>
                  <div class="form-group">
                    <label for=""> {{ __('Level-3 outcome') }}:</label>
                    <select name="maCDR3" id="" class="form-control">
                      @foreach ($cdr as $t)
                        @if ($t->maCDR1==$cdr1->maCDR1)
                              @if ($t->maCDR3==$x->maCDR3)
                                <option value="{{ $t->maCDR3 }}" selected> {{ $t->maCDR3VB }} - {{ $t->tenCDR3 }} </option>
                              @else
                                <option value="{{ $t->maCDR3 }}"> {{ $t->maCDR3VB }} - {{ $t->tenCDR3 }}</option> 
                              @endif
                          @endif
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="">ABET outcomes:</label>
                    <select name="maChuanAbet" id="" class="form-control">
                      @foreach ($chuan_abet as $abet)
                          {{-- @if ($abet->maChuanAbet=$x->maChuanAbet)
                          <option value="{{ $abet->maChuanAbet }}" selected>{{ $abet->maChuanAbetVB}}--{{ $abet->tenChuanAbet }} </option>
                          @else
                          <option value="{{ $abet->maChuanAbet }}">{{ $abet->maChuanAbetVB}}--{{ $abet->tenChuanAbet }}</option>
                          @endif --}}
                          <option value="{{ $abet->maChuanAbet }}">{{ $abet->maChuanAbetVB}}--{{ $abet->tenChuanAbet }}</option>
                           
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>
          </form>
            
            </div>
              @endif
   
     @endforeach
    @endforeach
  </tbody>
</table>
