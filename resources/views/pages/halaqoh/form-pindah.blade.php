@extends('layouts.tailwind')

@section('title', 'Pindah Halaqoh')

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6">
    <ol class="flex items-center gap-x-2 text-sm text-gray-500">
        <li><a href="/" class="hover:text-primary-600">Beranda</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li class="text-gray-900 font-medium">Pindah Halaqoh</li>
    </ol>
</nav>

<div class="max-w-lg mx-auto">
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Pindah Halaqoh</h2>

        <form action="{{ route('halaqoh.pindahPost') }}" method="POST" autocomplete="off">
            @csrf

            <div class="space-y-6">
                {{-- Halaqoh Awal --}}
                <div>
                    <label for="old_halaqoh" class="block text-sm font-medium text-gray-700 mb-1.5">Halaqoh Awal</label>
                    <select name="old_halaqoh" id="old_halaqoh" class="input-field">
                        <option disabled selected>-- Pilih Halaqoh Awal --</option>
                        @foreach($halaqoh as $h)
                            <option value="{{ $h->halaqoh_id }}" {{ $currentHalaqoh == $h->halaqoh_id ? 'selected' : '' }}>
                                {{ $h->pengajar_name. ' - ' . $h->program_name .' ('. $h->day . ' - '. $h->jenis_kbm .')' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @isset($peserta)
                {{-- Peserta --}}
                <div>
                    <label for="peserta" class="block text-sm font-medium text-gray-700 mb-1.5">Peserta</label>
                    <select name="peserta" id="peserta" class="input-field">
                        <option disabled selected>-- Pilih Peserta --</option>
                        @foreach($peserta as $p)
                            <option value="{{ $p->peserta_id }}">{{ $p->nis . ' - ' . $p->santri_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Halaqoh Tujuan --}}
                <div>
                    <label for="new_halaqoh" class="block text-sm font-medium text-gray-700 mb-1.5">Halaqoh Tujuan</label>
                    <select name="new_halaqoh" id="new_halaqoh" class="input-field">
                        <option disabled selected>-- Pilih Halaqoh Tujuan --</option>
                        @foreach($halaqoh as $h)
                            @if ($h->halaqoh_id != $currentHalaqoh)
                                <option value="{{ $h->halaqoh_id }}">
                                    {{ $h->pengajar_name. ' - ' . $h->program_name .' ('. $h->day . ' - '. $h->jenis_kbm .')' }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                @endisset
            </div>

            <div class="flex items-center justify-end gap-3 mt-10 pt-6 border-t border-gray-100">
                @isset($peserta)
                    <a href="/halaqoh/pindah" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">Submit</button>
                @else
                    <button type="button" id="cek" class="btn-primary">Cek</button>
                @endisset
            </div>
        </form>
    </div>
</div>

@endsection

@section('footer-script')
<script>
    document.getElementById("cek")?.addEventListener("click", cek);

    function cek() {
        let halaqohId = document.getElementById('old_halaqoh').value;
        let elemPeserta = document.getElementById('peserta');

        if (elemPeserta == null) {
            document.location = '/halaqoh/pindah/' + halaqohId;
        } else {
            let pesertaId = elemPeserta.value;
            document.location = '/halaqoh/pindah/' + halaqohId + '/' + pesertaId;
        }
    }
</script>
@endsection
