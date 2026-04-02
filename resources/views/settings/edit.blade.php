@extends('layouts.materialized')

@section('content')

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12">
                <h5 class="breadcrumbs-title">Edit Setting</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li><a href="{{ route('settings.index') }}">Settings</a></li>
                    <li class="active">Edit</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->
        

        <!--start container-->
        <div class="container" style="margin-bottom: 25px">
            <div class="section">
                <div class="row">
                    <div class="col s12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Edit Setting</span>
                                <form action="{{ route('settings.update', $setting) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-field">
                                        <input id="key" type="text" name="key" value="{{ $setting->key }}" required>
                                        <label for="key">Key</label>
                                    </div>
                                    <div class="input-field">
                                        <textarea id="value" name="value" class="materialize-textarea">{{ $setting->value }}</textarea>
                                        <label for="value">Value</label>
                                    </div>
                                    <div class="input-field">
                                        <select name="type" required>
                                            <option value="string" {{ $setting->type == 'string' ? 'selected' : '' }}>String</option>
                                            <option value="int" {{ $setting->type == 'int' ? 'selected' : '' }}>Integer</option>
                                            <option value="bool" {{ $setting->type == 'bool' ? 'selected' : '' }}>Boolean</option>
                                            <option value="json" {{ $setting->type == 'json' ? 'selected' : '' }}>JSON</option>
                                        </select>
                                        <label>Type</label>
                                    </div>
                                    <div class="input-field">
                                        <input id="group" type="text" name="group" value="{{ $setting->group }}">
                                        <label for="group">Group</label>
                                    </div>
                                    <div class="input-field">
                                        <textarea id="description" name="description" class="materialize-textarea">{{ $setting->description }}</textarea>
                                        <label for="description">Description</label>
                                    </div>
                                    <button type="submit" class="btn waves-effect waves-light">Update</button>
                                    <a href="{{ route('settings.index') }}" class="btn waves-effect waves-light grey">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection