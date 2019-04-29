<aside id="slide-out" class="side-nav white fixed">
    <div class="side-nav-wrapper">
        <div class="sidebar-profile">
            <div class="sidebar-profile-image">
                <img src="assets/images/profile-image.png" class="circle" alt="">
            </div>
            <div class="sidebar-profile-info">
                <a href="javascript:void(0);" class="account-settings-link">
                    <p>David Doe</p>
                    <span>david@gmail.com<i class="material-icons right">arrow_drop_down</i></span>
                </a>
            </div>
        </div>
    <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
        <li class="no-padding"><a class="waves-effect waves-grey" href="index.html"><i class="material-icons">settings_input_svideo</i>Dashboard</a></li>
        
        <li class="no-padding">
            <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">desktop_windows</i>Master<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
            <div class="collapsible-body">
                <ul>
                    <li><a href="{{ url('santri') }}">Daftar Santri</a></li>
                    <li><a href="{{ url('lembaga') }}">Daftar Lembaga</a></li>
                    <li><a href="{{ url('pengajar') }}">Daftar Pengajar</a></li>
                    <li><a href="{{ url('semester') }}">Daftar Semester</a></li>
                    <li><a href="{{ url('program') }}">Program Pendidikan</a></li>
                </ul>
            </div>
        </li>
        <li class="no-padding">
            <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">mode_edit</i>Forms<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
            <div class="collapsible-body">
                <ul>
                    <li><a href="form-elements.html">Form Elements</a></li>
                    <li><a href="form-wizard.html">Form Wizard</a></li>
                    <li><a href="form-upload.html">File Upload</a></li>
                    <li><a href="form-image-crop.html">Image Crop</a></li>
                    <li><a href="form-image-zoom.html">Image Zoom</a></li>
                    <li><a href="form-input-mask.html">Input Mask</a></li>
                    <li><a href="form-select2.html">Select2</a></li>
                </ul>
            </div>
        </li>
        <li class="no-padding active">
            <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">grid_on</i>Tables<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
            <div class="collapsible-body">
                <ul>
                    <li><a href="table-static.html">Static Tables</a></li>
                    <li><a href="table-responsive.html">Responsive Tables</a></li>
                    <li><a href="table-comparison.html">Comparison Table</a></li>
                    <li><a href="table-data.html" class="active-page">Data Tables</a></li>
                </ul>
            </div>
        </li>
        
    </ul>
    <div class="footer">
        <p class="copyright">IT FHQ An - Nashr © 2019</p>
    </div>
    </div>
</aside>