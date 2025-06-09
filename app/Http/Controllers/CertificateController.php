<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Http;

class CertificateController extends Controller
{
    public function create()
    {
        return view('certificates.create');
    }

    public function index()
    {
        $certificateList = Certificate::all();
        return view('certificates.index', compact('certificateList'));
    }

    public function uploadToIPFS(Request $request)
    {
        $request->validate([
            'certificate' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $file = $request->file('certificate');

        $response = Http::withHeaders([
            'pinata_api_key' => env('PINATA_API_KEY'),
            'pinata_secret_api_key' => env('PINATA_SECRET_API_KEY'),
        ])->attach(
            'file', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName()
        )->post('https://api.pinata.cloud/pinning/pinFileToIPFS');

        if ($response->successful()) {
            $ipfsHash = $response['IpfsHash'];
            $ipfsUrl = "https://ipfs.io/ipfs/" . $ipfsHash;

            Certificate::create([
                'name' => $file->getClientOriginalName(),
                'file_path' => $ipfsUrl,
            ]);

            return redirect()->route('certificates.index')->with('success', 'Certificate uploaded and stored on IPFS!');
        } else {
            return back()->with('error', 'IPFS upload failed');
        }
    }
}
