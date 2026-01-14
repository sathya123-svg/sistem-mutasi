@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded px-8 py-6">
            <h2 class="text-xl font-bold mb-4">Import Data Penduduk</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('penduduk.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-medium">File Excel (.xlsx)</label>
                    <input type="file" name="file" class="border p-2 w-full" required>
                </div>

                <div class="flex justify-end">
                <button
                type="submit"
                style="
                    background:#2ab806 !important;
                    color:#fff !important;
                    padding:8px 16px !important;
                    border:none !important;
                    border-radius:6px !important;
                    font-weight:600 !important;
                    cursor:pointer !important;
                ">
                Import
                </button>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
