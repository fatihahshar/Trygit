<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; 

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
            return view('memo.index', [
                'memos' => Memo::with('user')->latest()->get(),
            ]);

    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        //
        $validated = $request->validate([
            'memo' => 'required|string|max:255',
        ]);

        $request->user()->memo()->create($validated);

        return redirect(route('memo.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Memo $memo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Memo $memo) :View
    {
        
        $this->authorize('update', $memo);

        return view('memo.edit',[
            'memo' => $memo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Memo $memo) : RedirectResponse
    {
        //
        $this->authorize('update', $memo);

        $validated = $request->validate([
            'memo' => 'required|string|max:255',
        ]);

        $memo->update($validated);

        return redirect(route('memo.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Memo $memo) :RedirectResponse
    {
        //
        $this->authorize('delete', $memo);

        $memo->delete();

        return redirect(route('memo.index'));
    }
}
