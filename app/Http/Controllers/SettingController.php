<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the settings.
     */
    public function index()
    {
        $settings = Setting::all();
        return view('settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new setting.
     */
    public function create()
    {
        return view('settings.create');
    }

    /**
     * Store a newly created setting in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:settings',
            'value' => 'nullable',
            'type' => 'required|in:string,int,bool,json',
            'group' => 'nullable',
            'description' => 'nullable',
        ]);

        Setting::create($request->all());

        return redirect()->route('settings.index')->with('success', 'Setting created successfully.');
    }

    /**
     * Display the specified setting.
     */
    public function show(Setting $setting)
    {
        return view('settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified setting.
     */
    public function edit(Setting $setting)
    {
        return view('settings.edit', compact('setting'));
    }

    /**
     * Update the specified setting in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'key' => 'required|unique:settings,key,' . $setting->id,
            'value' => 'nullable',
            'type' => 'required|in:string,int,bool,json',
            'group' => 'nullable',
            'description' => 'nullable',
        ]);

        $setting->update($request->all());

        return redirect()->route('settings.index')->with('success', 'Setting updated successfully.');
    }

    /**
     * Remove the specified setting from storage.
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();

        return redirect()->route('settings.index')->with('success', 'Setting deleted successfully.');
    }
}
