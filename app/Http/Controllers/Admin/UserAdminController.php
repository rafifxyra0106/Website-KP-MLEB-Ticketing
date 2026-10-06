<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('reservasi');
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($sq) => $sq->where('name','like',"%$q%")->orWhere('email','like',"%$q%"));
        }
        if ($request->filled('role')) $query->where('role', $request->role);
        $users = $query->latest()->paginate(15)->withQueryString();
        return view('admin.users.index', compact('users'));
    }
    public function create() { return view('admin.users.form', ['user' => null]); }
    public function store(Request $request)
    {
        $request->validate(['name'=>'required','email'=>'required|email|unique:users','password'=>'required|min:8','role'=>'required|in:pengunjung,admin']);
        User::create(['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'password'=>Hash::make($request->password),'role'=>$request->role]);
        return redirect()->route('admin.users.index')->with('success','Pengguna berhasil ditambahkan.');
    }
    public function edit($id) { return view('admin.users.form', ['user' => User::findOrFail($id)]); }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate(['name'=>'required','email'=>'required|email|unique:users,email,'.$id,'role'=>'required|in:pengunjung,admin']);
        $data = $request->only('name','email','phone','role');
        if ($request->filled('password')) { $request->validate(['password'=>'min:8']); $data['password'] = Hash::make($request->password); }
        $user->update($data);
        return redirect()->route('admin.users.index')->with('success','Pengguna berhasil diperbarui.');
    }
    public function destroy($id)
    {
        if ($id == auth()->id()) return back()->with('error','Tidak dapat menghapus akun sendiri.');
        User::findOrFail($id)->delete();
        return back()->with('success','Pengguna berhasil dihapus.');
    }
}
