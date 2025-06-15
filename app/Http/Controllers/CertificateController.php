<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\Tutor;
use Illuminate\Support\Facades\Http;

class CertificateController extends Controller
{
    public function create()
    {
        $tutors = Tutor::all(); // Change to User::where('role', 'tutor')->get() if no Tutor model
        return view('certificates.create', compact('tutors'));
    }

    public function index()
    {
        $certificateList = Certificate::with('tutor')->get();
        return view('certificates.index', compact('certificateList'));
    }

    public function uploadToIPFS(Request $request)
    {
        $request->validate([
            'certificate' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'tutor_id' => 'required|exists:tutors,id', // use users,id if no tutors table
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
                'tutor_id' => $request->input('tutor_id'),
                'name' => $file->getClientOriginalName(),
                'file_path' => $ipfsUrl,
            ]);

            return redirect()->route('certificates.index')->with('success', 'Certificate uploaded and stored on IPFS!');
        } else {
            return back()->with('error', 'IPFS upload failed');
        }
    }

    //parent view
    public function publicView()
    {
        $certificates = \App\Models\Certificate::with('tutor')->latest()->get();
        return view('about', compact('certificates'));
    }


}
