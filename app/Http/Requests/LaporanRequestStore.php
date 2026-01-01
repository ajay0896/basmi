<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaporanRequestStore extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'deskripsi'    => [
                'required',
                'string',
                'min:15',  // Turun dari 20 ke 15 - lebih user friendly
                'max:5000',
            ],
            'lokasi'       => 'required|string|min:5',
            'lampiran'     => 'nullable|file|mimes:jpeg,jpg,png,pdf,mp4|max:5120',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            // 'desa_id'      => 'required|exists:desas,id',
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
            'deskripsi.required' => 'Deskripsi kejadian wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal 15 karakter. Contoh: "Ada pungli Rp 50rb di terminal"',
            'deskripsi.max' => 'Deskripsi maksimal 5000 karakter.',
            'lokasi.required' => 'Lokasi kejadian wajib diisi.',
            'lokasi.min' => 'Lokasi minimal 5 karakter.',
            'lampiran.mimes' => 'File lampiran harus berformat JPEG, JPG, PNG, PDF, atau MP4.',
            'lampiran.max' => 'Ukuran file lampiran maksimal 5MB.',
            'kecamatan_id.required' => 'Kecamatan wajib dipilih.',
            'kecamatan_id.exists' => 'Kecamatan yang dipilih tidak valid.',
        ];
    }
}
