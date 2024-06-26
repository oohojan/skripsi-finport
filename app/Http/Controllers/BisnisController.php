<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BisnisController extends Controller
{
    public function bisnis()
    {
        $umkm = UMKM::where('id_user', Auth::id())->first();
        $employees = Employee::where('id_umkm', $umkm->id)->get();

        return view('bisnis_anda', compact('umkm', 'employees'));
    }

    public function umkm(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $umkm = Umkm::where('nama_umkm', 'LIKE', "%{$search}%")->paginate(10);
        } else {
            $umkm = Umkm::paginate(10);
        }

        return view('umkm-list', ['umkm' => $umkm]);
    }

    public function joinUmkm($id)
    {
        $user = User::find(Auth::id());

        if (!$user) {
            return redirect()->back()->with('error', 'You need to be logged in to join a UMKM.');
        }

        $isAlreadyEmployee = Employee::where('id_user', $user->id)
                                    ->where('id_umkm', $id)
                                    ->exists();

        if (!$isAlreadyEmployee) {
            Employee::create([
                'id_user' => $user->id,
                'id_umkm' => $id,
                'status' => 'pending',
            ]);

            return redirect()->route('profile')->with('success', 'You have successfully applied to join the UMKM. Please wait for the owner to accept you.');
        } else {
            return redirect()->route('profile')->with('error', 'You have already applied to join this UMKM.');
        }
    }

    public function updateEmployeeStatus(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return redirect()->route('bisnis_anda')->with('error', 'Employee not found.');
        }

        // Update status employee
        $employee->status = $request->status;

        if ($request->status == 'accepted') {
            $user = User::find($employee->id_user);
            if ($user) {
                $user->have_business = 1;
                $user->save();
            }
            $employee->save();
        } elseif ($request->status == 'declined') {
            $employee->save();
        } else {
            return redirect()->route('bisnis_anda')->with('error', 'Invalid status update.');
        }

        return redirect()->route('bisnis_anda')->with('success', 'Employee status updated successfully.');
    }

    public function add(){
        return view('add-umkm');
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama_umkm' => 'required|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        // Simpan data UMKM
        $umkm = new UMKM();
        $umkm->nama_umkm = $request->nama_umkm;
        $umkm->alamat_umkm = $request->alamat;
        $umkm->id_user = Auth::id(); // Mengambil ID user yang sedang login
        $umkm->save();

        // Update kolom have_business di tabel users
        $user = User::find(Auth::id());
        $user->have_business = true; // Ubah have_business menjadi 1 atau true
        $user->id_role = 1;
        $user->save();

        // Redirect atau tampilkan pesan sukses
        return redirect()->route('dashboard_owner')->with('success', 'UMKM berhasil ditambahkan.');
    }

    public function editBisnis(Request $request){
        $umkm = UMKM::where('id_user', Auth::id())->first();
        return view('edit-bisnis_anda', compact('umkm'));
    }

    public function updateBisnis(Request $request, $id)
    {
        $request->validate([
            'nama_umkm' => 'required|string|max:255',
            'alamat_umkm' => 'required|string|max:255',
        ]);

        $umkm = UMKM::find($id);
        if (!$umkm) {
            return redirect()->route('bisnis.edit', $id)->with('error', 'UMKM not found.');
        }

        $umkm->nama_umkm = $request->nama_umkm;
        $umkm->alamat_umkm = $request->alamat_umkm;

        if ($umkm->save()) {
            return redirect()->route('bisnis_anda')->with('success', 'UMKM updated successfully.');
        } else {
            return redirect()->route('bisnis.edit', $id)->with('error', 'Failed to update UMKM.');
        }
    }
}
