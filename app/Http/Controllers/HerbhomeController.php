<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Herb;

class HerbhomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Herb::sortable();
        if ($request->filled('name_search')) {
            $query->where('name', 'like', '%' . $request->name_search . '%');
        }
        $records = $query->paginate(10);

        $binding = [
            'records' => $records,
        ];
        
        return view('dashboard', $binding);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'sciname' => 'required',
            'famname' => 'required',
            'genname' => 'required',
            'type' => 'required',
        ]);

        $input = $request->all();

        $data = [
            'name' => $input['name'],
            'sciname' => $input['sciname'],
            'famname' => $input['famname'],
            'genname' => $input['genname'],
            'alias' => $input['alias'],
            'type' => $input['type'],
            'medparts' => $input['medparts'],
            'effect' => $input['effect'],
            'area' => $input['area'],
        ];

        Herb::create($data);

        return redirect()->route('herbhome.index')->with('message', '新增成功');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = Herb::find($id);

        $validated = $request->validate([
            'name' => 'required',
            'sciname' => 'required',
            'famname' => 'required',
            'genname' => 'required',
            'type' => 'required',
        ]);

        $input = $request->all();

        $data = [
            'name' => $input['name'],
            'sciname' => $input['sciname'],
            'famname' => $input['famname'],
            'genname' => $input['genname'],
            'alias' => $input['alias'],
            'type' => $input['type'],
            'medparts' => $input['medparts'],
            'effect' => $input['effect'],
            'area' => $input['area'],
        ];

        $record->update($data);

        return redirect()->route('herbhome.index')->with('message', '編輯成功');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Herb::find($id);
        $record->delete();

        return redirect()->route('herbhome.index');
    }
}
