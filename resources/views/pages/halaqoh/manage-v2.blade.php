@extends('layouts.materialized')

@section('header-script')
<style type="text/css">

    li.active a {
        color: white;
    }

    table.bordered td,
    table.bordered th {
        border: 1px solid rgba(0, 0, 0, .12) !important;
        padding: 15px !important;
    }

    .d-none {
        display: none;
    }

    .d-block {

    }
    span.badge {
        position: inherit;
    }
    span.badge.new:after {
        content: "";
    }
    .btn-move-up {
        top: -8px;
    }
    h6 {
        font-size: 1.1rem;
        line-height: 180%;
    }
</style>
@endsection

@section('footer-script')
{{-- <script>
    function loadPeserta(reference, day, program, kbm) {

        $("#modalDay").html(day);
        $("#modalProgram").html(program);
        $("#modalKbm").html(kbm);

        $.get("/api/halaqoh/"+reference+"/peserta", function(res){
            console.log(res);
            $('.modal-collection-item').remove();
            res.forEach(function(obj){
                let color = "cyan";
                if (obj.gender == 'FEMALE') color = 'pink accent-2';

                let chip = `<div class="chip ${color} white-text class="secondary-content""> <i class="mdi-social-person-outline"></i> <span id="modalPengajar"></span> ${obj.umur} Thn </div>`;
                let elem = `<div class='modal-collection-item collection-item' id="collection-item-${obj.reference}">
                    <div> ${obj.santri_name} <a class="secondary-content">${chip}</a></diV>
                </div>`;

                $("#modal-collection").append(elem);
            });
        });

        $('#modal').openModal();

    }
</script> --}}
<script>
  let draggedItem = null;

  document.querySelectorAll('li').forEach(item => {
    item.addEventListener('dragstart', (e) => {
      draggedItem = item;
      setTimeout(() => item.style.display = 'none', 0);
    });

    item.addEventListener('dragend', () => {
      setTimeout(() => {
        draggedItem.style.display = 'block';
        draggedItem = null;
      }, 0);
    });
  });

  document.querySelectorAll('ul').forEach(list => {
    list.addEventListener('dragover', (e) => {
      e.preventDefault();
    });

    list.addEventListener('dragenter', (e) => {
      e.preventDefault();
      list.classList.add('drag-over');
    });

    list.addEventListener('dragleave', () => {
      list.classList.remove('drag-over');
    });

    list.addEventListener('drop', () => {
      list.classList.remove('drag-over');
      if (draggedItem) {

        let pesertaRef = draggedItem.getAttribute("data-ref");
        let halaqohRef = list.getAttribute("data-ref");

        let buttonSave = document.createElement("button");
        buttonSave.innerHTML = "Save";
        buttonSave.setAttribute("data-peserta-ref", pesertaRef);
        buttonSave.setAttribute("data-halaqoh-ref", halaqohRef);
        buttonSave.addEventListener('click', (el)=>{
            $.get("/api/peserta/" + el.target.getAttribute("data-peserta-ref") +"/pindah/"+ el.target.getAttribute("data-halaqoh-ref"), function(res){
                console.log(res);
                buttonSave.style.display = "none";
            });

        });

        draggedItem.appendChild(buttonSave);
        list.appendChild(draggedItem);

      }
    });
  });

    @if (!empty(Request::get('semester_id'))) 
        $('#filter-semester').val({{ Request::get('semester_id') }}).trigger('change');
    @endif
</script>
@endsection

@section('content')

<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Manage Peserta</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li class="active">Manage Peserta</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs end-->


<!--start container-->
<div class="container" style="margin-bottom: 25px">
    <div class="section">

        <div class="row">
            <div class="col s12">
                @include('layouts.materialized.components.alert')
            </div>
        </div>  

        <div class="row">
            <div class="col s12" style="margin-bottom:1rem">

                <form action="" method="get" style="display: inline-flex; align-items:center; gap:1.5rem;">
                    <select name="semester_id" id="filter-semester" class="browser-default">
                        <option value="">- Pilih Semester -</option>
                        @foreach ($semesterList as $item)
                            <option value="{{ $item->id }}">Semester {{ $item->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Pilih</button>
                </form>

            </div>
        </div>

        <div class="row">

            <div class="col s12">
                <ul class="tabs tab-demo-active z-depth-1 cyan" style="width: 100%;">
                    @foreach ($days as $d)
                        <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#{{ $d }}-container">{{ $d }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col s12" style="padding: 10px">

                @php $i = 0 @endphp
                @foreach ($data as $day => $halaqoh)
                    <div id="{{ $day }}-container" class="col s12 tab-container" style="display: {{ (++$i == 1) ? 'block' : 'none' }}">

                        @foreach($program as $o)
                            @isset($halaqoh[$o->id])
                                @foreach($halaqoh[$o->id] as $h)
                                    <div class="col s12 m6 l4 program-container {{ empty($halaqoh[$o->id]) ? 'd-none' : '' }}">
                                        
                                        <div class="{{ @$h->gender == 'FEMALE' ? 'pink' : 'cyan' }} white-text program-container-header" style="width:100%; padding:15px;">
                                            <h6 class="mb-3" style="font-weight:300;">{{ $o->name }} - {{ $h->pengajar ?? "Belum Ditentukan" }}</h6>
                                            <small class="mb-3" style="font-weight:300;">{{ $h->peserta_count ?? 0 }} Peserta</small> 
                                            
                                            @allow('admin::manage::halaqoh')

                                                <a class="btn-floating activator btn-move-up waves-effect waves-light red accent-2 z-depth-4 right" href="/halaqoh/{{ $h->reference }}/edit-data?ref=halaqoh.manage.v2">
                                                    <i class="mdi-action-settings"></i>
                                                </a>

                                                <a class="btn-floating activator btn-move-up waves-effect waves-light red accent-2 z-depth-4 right" href="/halaqoh/add?hari={{ $day }}&program={{ $o->id }}&kbm={{ $h->jenis_kbm }}&gender={{ $h->gender }}&ref=/halaqoh/manage/v2">
                                                    <i class="mdi-social-person-add"></i>
                                                </a>

                                                <a class="btn-floating activator btn-move-up waves-effect waves-light red accent-2 z-depth-4 right" href="/halaqoh/{{ $h->reference }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><title>magnify</title><path fill="white" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" /></svg>
                                                </a>
                                                
                                            @endallow
                                            
                                            @if(strtoupper($h->jenis_kbm) == "ONLINE") <span class="badge new green">Online</span> @endif
                                        </div>

                                        <ul class="collection program-container-body" id="collection-{{ $h->reference }}" data-ref="{{ $h->reference }}" style="width:100%;height:270px;overflow-y:scroll">
                                            
                                            @foreach($h->peserta as $peserta)
                                            <li class="collection-item" @allow('admin::manage::halaqoh') draggable="true" @endallow id="collection-item-{{ $peserta->peserta_reference }}" data-ref="{{ $peserta->peserta_reference }}">
                                                <div class="row">
                                                    <div class="col s8"><label>{{ $peserta->santri_name }}</label></div>
                                                    
                                                    @allow('rekap-nilai.view')
                                                    <div class="col s4">
                                                        <div class="chip {{ $peserta->gender == 'FEMALE' ? 'pink accent-2' : 'cyan' }} white-text secondary-content"> <i class="mdi-social-person-outline"></i> <span id="modalPengajar"></span> {{ $peserta->umur }} Thn </div>
                                                    </div>
                                                    @endallow

                                                </div>
                                            </li>
                                            @endforeach

                                            @allow('admin::manage::halaqoh')
                                            <li class="collection-item">
                                                <a href="{{ route('halaqoh.peserta.add', ['halaqohId' => $h->reference]) }}" class="" style="text-align: center"> (+) Tambah Peserta </a> 
                                            </li>
                                            @endallow
                                        </ul>
                                    </div>                            
                                @endforeach
                            @endisset
                        @endforeach

                    </div>                    
                @endforeach
            </div>
        </div>
    </div>
</div>


<div id="modal" class="modal modal-fixed-footer" >
    <div class="modal-content" style="padding: 0">
        <ul class="collection with-header" style="margin-top: 0" id="modal-collection">
            <li class="collection-header">
                <h5>Daftar Peserta Halaqoh</h5>
                <p>
                    <div class="chip cyan white-text"> <i class="mdi-action-event"></i> <span id="modalKbm"></span> </div>
                    <div class="chip cyan white-text"> <i class="mdi-action-event"></i> <span id="modalDay"></span> </div>
                    <div class="chip cyan white-text"> <i class="mdi-content-flag"></i> <span id="modalProgram"></span> </div>
                </p>
            </li>
        </ul>
    </div>
    <div class="modal-footer">
    <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Cancel</a>
    </div>
</div>
<!--end container-->

@endsection