@extends('layouts.tailwind')

@section('title', 'Tambah Peserta Halaqoh')

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6">
    <ol class="flex items-center gap-x-2 text-sm text-gray-500">
        <li><a href="/" class="hover:text-primary-600">Beranda</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li class="text-gray-900 font-medium">Tambah Peserta Halaqoh</li>
    </ol>
</nav>

<div class="max-w-lg mx-auto">
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Tambah Peserta Halaqoh</h2>

        <form action="{{ route('halaqoh.peserta.addPost') }}" method="POST" autocomplete="off">
            @csrf

            <div class="space-y-6">
                {{-- Halaqoh --}}
                <div>
                    <label for="halaqoh" class="block text-sm font-medium text-gray-700 mb-1.5">Halaqoh</label>
                    <select name="halaqoh" id="halaqoh" class="input-field">
                        <option disabled selected>-- Pilih Halaqoh --</option>
                        @foreach($halaqoh as $h)
                            <option value="{{ $h->halaqoh_id }}">{{ $h->pengajar_name. ' - ' . $h->program_name .' ('. $h->day . ' - '. $h->jenis_kbm .')'  }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Santri --}}
                <div>
                    <label for="santri" class="block text-sm font-medium text-gray-700 mb-1.5">Peserta</label>
                    <select name="santri" id="santri" class="input-field">
                        <option disabled selected>-- Pilih Santri --</option>
                        @foreach($peserta as $santri)
                            <option value="{{ $santri->id }}">{{ $santri->name . ' - ' . $santri->nis }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-10 pt-6 border-t border-gray-100">
                <a href="/halaqoh/peserta/add" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('footer-script')
<script>
    @if (!empty($selectedHalaqoh))
        document.getElementById('halaqoh').value = {{ $selectedHalaqoh->halaqoh_id }};
    @endif
</script>
@endsection
