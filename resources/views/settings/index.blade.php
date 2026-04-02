@extends('layouts.materialized')

@section('header-script')
<style type="text/css">
    table td, table th {
        border : 1px solid #ddd;
    }
</style>
@endsection

@section('content')

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12">
                <h5 class="breadcrumbs-title">Settings</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li class="active">Settings</li>
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
                                <span class="card-title">Application Settings</span>
                                <a href="{{ route('settings.create') }}" class="btn waves-effect waves-light">Add Setting</a>
                                <table class="striped">
                                    <thead>
                                        <tr>
                                            <th>Key</th>
                                            <th>Value</th>
                                            <th>Type</th>
                                            <th>Group</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($settings as $setting)
                                        <tr>
                                            <td>{{ $setting->key }}</td>
                                            <td>{{ $setting->value }}</td>
                                            <td>{{ $setting->type }}</td>
                                            <td>{{ $setting->group }}</td>
                                            <td>{{ $setting->description }}</td>
                                            <td>
                                                <a href="{{ route('settings.edit', $setting) }}" class="btn-small">Edit</a>
                                                <form action="{{ route('settings.destroy', $setting) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-small red" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection