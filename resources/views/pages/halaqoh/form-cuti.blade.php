@extends('layouts.tailwind')

@section('title', 'Form Cuti')

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6">
    <ol class="flex items-center gap-x-2 text-sm text-gray-500">
        <li><a href="/" class="hover:text-primary-600">Beranda</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li class="text-gray-900 font-medium">Form Cuti</li>
    </ol>
</nav>

<div class="space-y-6">
    {{-- Cuti Form --}}
    <div class="max-w-xl mx-auto">
        <div class="card">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Form Cuti Peserta</h2>

            <form action="{{ route('halaqoh.peserta.cuti') }}" method="POST" id="cuti-form" autocomplete="off">
                @csrf

                <div>
                    <label for="id" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Peserta</label>
                    <select name="id" id="id" class="input-field">
                        <option selected>-- Pilih Peserta --</option>
                        @foreach($peserta_active as $p)
                            <option value="{{ $p->peserta_id }}">{{ $p->santri_name . " ($p->program_name, $p->pengajar_name, $p->day)" }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end mt-10 pt-6 border-t border-gray-100">
                    <button type="button" id="btnCuti" class="btn-danger">Cuti</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar Peserta Cuti --}}
    <div class="card">
        <h3 class="text-base font-semibold text-gray-900 mb-3">Daftar Peserta Cuti</h3>

        {{-- Mobile card view --}}
        <div class="block sm:hidden space-y-3">
            @forelse ($peserta_cuti as $p)
                <div class="rounded-lg border border-gray-200 p-4">
                    <p class="font-medium text-gray-900">{{ $p->santri_name }}</p>
                    <p class="text-sm text-gray-500 mt-1">Program: {{ $p->program_name }}</p>
                    <p class="text-sm text-gray-500">Pengajar: {{ $p->pengajar_name }}</p>
                    <div class="mt-3">
                        <button type="button" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-100" onclick="confirmRestore(this)" data-id="{{ $p->peserta_id }}">Pulihkan</button>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 text-center py-4">Tidak ada peserta cuti</p>
            @endforelse
        </div>

        {{-- Desktop table view --}}
        <div class="hidden sm:block overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-primary-600">
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Nama</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Program</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Pengajar Terakhir</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-white uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($peserta_cuti as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-sm text-gray-900">{{ $p->santri_name }}</td>
                            <td class="px-3 py-2 text-sm text-gray-700">{{ $p->program_name }}</td>
                            <td class="px-3 py-2 text-sm text-gray-700">{{ $p->pengajar_name }}</td>
                            <td class="px-3 py-2 text-center">
                                <button type="button" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-100" onclick="confirmRestore(this)" data-id="{{ $p->peserta_id }}">Pulihkan</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-6 text-center text-sm text-gray-500">Tidak ada peserta cuti</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('footer-script')
<script>
function confirmInputCuti() {
    var span = document.createElement("span");
    span.innerHTML = "Apakah anda yakin ingin merubah status peserta menjadi <b>CUTI</b> ?";

    swal({
        title: "Konfirmasi Cuti",
        content: span,
        icon: "warning",
        buttons: true,
    }).then((willCuti) => {
        if (willCuti) {
            document.getElementById('cuti-form').submit();
        }
    });
}

function confirmRestore(e) {
    var span = document.createElement("span");
    span.innerHTML = "Apakah anda yakin ingin memulihkan status peserta menjadi <b>AKTIF</b> ?";

    swal({
        title: "Konfirmasi Pemulihan",
        content: span,
        icon: "warning",
        buttons: true,
    }).then((willCuti) => {
        if (willCuti) {
            document.location = "{{ route('halaqoh.peserta.cuti.restore') }}/" + e.getAttribute("data-id");
        }
    });
}

document.getElementById("btnCuti").addEventListener("click", confirmInputCuti);
</script>
@endsection
