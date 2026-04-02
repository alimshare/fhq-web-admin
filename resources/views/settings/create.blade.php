@extends('layouts.materialized')

@section('content')

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12">
                <h5 class="breadcrumbs-title">Add Setting</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li><a href="{{ route('settings.index') }}">Settings</a></li>
                    <li class="active">Add</li>
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
                                <span class="card-title">Create New Setting</span>
                                <form action="{{ route('settings.store') }}" method="POST">
                                    @csrf
                                    <div class="input-field">
                                        <input id="key" type="text" name="key" required>
                                        <label for="key">Key</label>
                                    </div>
                                    <div class="input-field">
                                        <textarea id="value" name="value" class="materialize-textarea"></textarea>
                                        <label for="value">Value</label>
                                    </div>
                                    <div class="input-field">
                                        <select name="type" required>
                                            <option value="string">String</option>
                                            <option value="int">Integer</option>
                                            <option value="bool">Boolean</option>
                                            <option value="json">JSON</option>
                                        </select>
                                        <label>Type</label>
                                    </div>
                                    <div class="input-field">
                                        <input id="group" type="text" name="group">
                                        <label for="group">Group</label>
                                    </div>
                                    <div class="input-field">
                                        <textarea id="description" name="description" class="materialize-textarea"></textarea>
                                        <label for="description">Description</label>
                                    </div>
                                    <button type="submit" class="btn waves-effect waves-light">Save</button>
                                    <a href="{{ route('settings.index') }}" class="btn waves-effect waves-light grey">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection