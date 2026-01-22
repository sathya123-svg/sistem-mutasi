@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl mx-auto">

    <h1 class="text-2xl font-bold mb-4">
        Edit Anggota Keluarga
    </h1>

    <p class="mb-4 text-gray-600">
        KK: <strong>{{ $kk->nomor_kk }}</strong><br>
        Nama Anggota: <strong>{{ $penduduk->nama }}</strong>
    </p>

    <form method="POST" action="{{ route('kk.updateAnggota', [$kk->id, $penduduk->id]) }}">
        @csrf
        @method('PUT')

        {{-- Hubungan Keluarga --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Hubungan Keluarga</label>
            <select name="hubungan_keluarga" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih --</option>
                <option value="Suami" @selected($penduduk->hubungan_keluarga === 'Suami')>Suami</option>
                <option value="Istri" @selected($penduduk->hubungan_keluarga === 'Istri')>Istri</option>
                <option value="Anak" @selected($penduduk->hubungan_keluarga === 'Anak')>Anak</option>
            </select>
        </div>

        {{-- Anak ke --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Anak Ke</label>
            <input
                type="number"
                name="anak_ke"
                id="anak_ke"
                min="1"
                value="{{ $penduduk->anak_ke }}"
                class="w-full border p-2 rounded"
                placeholder="Isi jika hubungan = Anak"
                @disabled($penduduk->hubungan_keluarga !== 'Anak')
            >
        </div>

        {{-- Tombol --}}
        <div class="flex gap-2">
                <button
                    type="submit"
                    style="
                        background:#0653b8 !important;
                        color:#fff !important;
                        padding:8px 16px !important;
                        border:none !important;
                        border-radius:6px !important;
                        font-weight:600 !important;
                        cursor:pointer !important;
                    ">
                    Simpan
                </button>

            <a href="{{ route('kk.show', $kk->id) }}"
               class="bg-gray-500 text-white px-4 py-2 rounded">
                Batal
            </a>
        </div>
    </form>
    
    <script>
    const hubunganSelect = document.querySelector('select[name="hubungan_keluarga"]');
    const anakKeInput = document.getElementById('anak_ke');

    function toggleAnakKe() {
        if (hubunganSelect.value === 'Anak') {
            anakKeInput.disabled = false;
        } else {
            anakKeInput.value = '';
            anakKeInput.disabled = true;
        }
    }

    hubunganSelect.addEventListener('change', toggleAnakKe);

    // jalankan saat halaman pertama kali dibuka
    toggleAnakKe();
</script>


</div>
@endsection
