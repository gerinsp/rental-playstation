<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member = Member::paginate(5);
        return view('member.index', [
            'title' => 'Data Member',
            'active' => 'member',
            'members' => $member
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('member.create', [
            'title' => 'Create Member',
            'active' => 'member'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|min:3',
            'jenis_kelamin' => 'required',
            'no_telepon' => 'required',
            'alamat' => 'required'
        ]);

        Member::create($validatedData);

        return redirect('members')->with('success', 'Data member berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = Member::find($id)->first();
        return view('member.edit', [
            'title' => 'Edit Member',
            'active' => 'member',
            'member' => $member
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|min:3',
            'jenis_kelamin' => 'required',
            'no_telepon' => 'required|max:12|min:12',
            'alamat' => 'required'
        ]);

        Member::where('id', $id)->update($validatedData);

        return redirect('members')->with('success', 'Data member berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Member::destroy($id);
        return redirect('members')->with('success', 'Data member berhasil dihapus.');
    }
}
