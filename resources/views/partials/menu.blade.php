<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('data_kependudukan_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/kependudukans*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.dataKependudukan.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('kependudukan_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.kependudukans.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/kependudukans") || request()->is("admin/kependudukans/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.kependudukan.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        {{-- @can('surat_menyurat_access') --}}
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/entry-mails*") ? "menu-open" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-envelope c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.suratMenyurat.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    {{-- @can('entry_mail_access') --}}
                        {{-- <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.entry-mails.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/entry-mails") || request()->is("admin/entry-mails/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-envelope c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.entryMail.title') }}
                            </a>
                        </li> --}}
                    {{-- @endcan --}}
                    {{-- @can('pengajuan_surat_access') --}}
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("portal.pengajuan-surat.index") }}" class="c-sidebar-nav-link {{ request()->is("portal/pengajuan-surat") || request()->is("portal/pengajuan-surat/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-envelope c-sidebar-nav-icon">

                                </i>
                                Pengajuan Surat
                            </a>
                        </li>
                    {{-- @endcan --}}
                </ul>
            </li>
        {{-- @endcan --}}
        @can('pengumuman_dan_beritum_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/berita*") ? "menu-open" : "" }} {{ request()->is("admin/pengumuman*") ? "menu-open" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle {{ request()->is("admin/berita*") ? "active" : "" }} {{ request()->is("admin/pengumuman*") ? "active" : "" }}" href="#">
                    <i class="fa-fw c-sidebar-nav-icon fas fa-newspaper">

                    </i>
                    <p>
                        {{ trans('cruds.pengumumanDanBeritum.title') }}
                        <i class="right fa fa-fw fa-angle-left c-sidebar-nav-icon"></i>
                    </p>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('beritum_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.berita.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/berita") || request()->is("admin/berita/*") ? "active" : "" }}">
                                <i class="fa-fw c-sidebar-nav-icon fab fa-hacker-news">

                                </i>
                                <p>
                                    {{ trans('cruds.beritum.title') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('pengumuman_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.pengumuman.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/pengumuman") || request()->is("admin/pengumuman/*") ? "active" : "" }}">
                                <i class="fa-fw c-sidebar-nav-icon fas fa-volume-up">

                                </i>
                                <p>
                                    {{ trans('cruds.pengumuman.title') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('rule_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.rules.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/rules") || request()->is("admin/rules/*") ? "active" : "" }}">
                                <i class="fa-fw c-sidebar-nav-icon fas fa-volume-up">

                                </i>
                                <p>
                                    {{ trans('cruds.rule.title') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>