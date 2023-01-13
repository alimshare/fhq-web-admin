
    <aside id="left-sidebar-nav">
        <ul id="slide-out" class="side-nav fixed leftside-navigation">
            <li class="user-details cyan darken-2">
            <div class="row">
                <div class="col col s4 m4 l4">
                    <img src="/images/user-default.png" alt="" class="circle responsive-img valign profile-image">
                </div>
                <div class="col col s8 m8 l8">
                    <!-- <ul id="profile-dropdown" class="dropdown-content">
                        <li><a href="#"><i class="mdi-action-face-unlock"></i> Profile</a>
                        </li>
                        <li><a href="#"><i class="mdi-action-settings"></i> Settings</a>
                        </li>
                        <li><a href="#"><i class="mdi-communication-live-help"></i> Help</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="mdi-action-lock-outline"></i> Lock</a>
                        </li>
                        <li><a href="#"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
                        </li>
                    </ul> -->
                    <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="{{ route('profile') }}" data-activates="profile-dropdown">
                        {{ Auth::user()->name }}
                        <!-- <i class="mdi-navigation-arrow-drop-down right"></i> --></a>
                    <p class="user-roal">NIP : {{ Auth::user()->profile->nip }}</p>
                </div>
            </div>
            </li>

            <li class="bold"><a href="/profile" class="waves-effect waves-cyan"><i class="mdi-action-account-circle"></i> Profile</a></li>
            <li class="bold"><a href="/absensi" class="waves-effect waves-cyan"><i class="mdi-action-assignment-ind"></i> Absensi</a></li>
            
            @allow('list-halaqoh')
            <li class="bold"><a href="/halaqoh" class="waves-effect waves-cyan"><i class="mdi-toggle-radio-button-off"></i> Riwayat Halaqoh</a></li>
            @endallow

            <li class="bold"><a href="/halaqoh/manage" class="waves-effect waves-cyan"><i class="mdi-toggle-radio-button-off"></i> Halaqoh Aktif</a></li>

            @allow('edit-halaqoh')
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-action-view-carousel"></i> Manajemen Halaqoh</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="{{ route('halaqoh.add') }}">Tambah Halaqoh</a></li>
                                <li><a href="{{ route('halaqoh.peserta.add') }}">Tambah Peserta</a></li>
                                <li><a href="{{ route('halaqoh.pindah') }}">Pindah Halaqoh</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            @endallow
            
            @allow('list-pengajar')
            <li class="bold"><a href="/pengajar" class="waves-effect waves-cyan"><i class="mdi-social-person-outline"></i> Pengajar</a></li>
            @endallow
            
            @allow('list-santri')
            <li class="bold"><a href="/santri" class="waves-effect waves-cyan"><i class="mdi-social-people-outline"></i> Santri</a></li>
            @endallow
            
            @allow('list-program')
            <li class="bold"><a href="/program" class="waves-effect waves-cyan"><i class="mdi-image-assistant-photo"></i> Program</a></li>
            @endallow
            
            @allow('list-lembaga')
            <li class="bold"><a href="/lembaga" class="waves-effect waves-cyan"><i class="mdi-social-location-city"></i> Lembaga</a></li>
            @endallow
            
            <li class="li-hover"><div class="divider"></div></li>
            @allow('list-role')
            <li class="bold"><a href="/role" class="waves-effect waves-cyan"><i class="mdi-social-location-city"></i> Role</a></li>
            @endallow

            @allow('users')
            <li class="bold"><a href="{{ route('users') }}" class="waves-effect waves-cyan"><i class="mdi-social-people"></i> Users</a></li>
            @endallow

            <li class="li-hover"><div class="divider"></div></li>
            <!-- <li class="bold"><a href="/santri" class="waves-effect waves-cyan"><i class="mdi-action-account-circle"></i> User Aplikasi</a></li> -->
            
            @allow('rekap-nilai.view')
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-action-view-carousel"></i> Monitor</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="{{ route('rekap.nilai') }}">Rekap Nilai</a></li>
                                <li><a href="{{ route('rekap.kbm') }}">Rekap KBM</a></li>
                                <li><a href="{{ route('rekap.kehadiran') }}">Rekap Kehadiran</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            @endallow

            <li class="li-hover"><div class="divider"></div></li>

            @allow('change-password')
            <li class="bold"><a href="/change-password" class="waves-effect waves-cyan"><i class="mdi-communication-vpn-key"></i> Ubah Password</a></li>
            @endallow
            
            @if(!empty(env('GUIDE_URL')))
            <li class="bold"><a href="{{ env('GUIDE_URL', '#') }}" target="_blank" class="waves-effect waves-cyan"><i class="mdi-action-info"></i> Panduan</a></li>
            @endif
            
            <li class="bold">
                <a onclick="logout()" class="waves-effect waves-cyan">
                    <i class="mdi-hardware-keyboard-tab"></i> Log Out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </li>
            
        </ul>
        <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
    </aside>