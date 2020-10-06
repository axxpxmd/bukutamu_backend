<ul class="sidebar-menu">
    <li class="header"><strong>MAIN NAVIGATION</strong></li>
    <li>
        <a href="{{ route('home') }}">
            <i class="icon icon-dashboard2 blue-text s-18"></i> 
            <span>Dashboard</span>
        </a>
    </li>
    {{-- @can('master-template') --}}
    <li class="header light"><strong>CONFIG TEMPLATE</strong></li>
    <li>
        <a href="{{ route('config-template.template.index') }}">
            <i class="icon icon-paper-plane red-text s-18"></i> 
            <span>Template</span>
        </a>
    </li>
    {{-- @endcan --}}
    {{-- @can('master-role') --}}
    <li class="header light"><strong>MASTER ROLES</strong></li>
    <li>
        <a href="{{ route('master-role.role.index') }}">
            <i class="icon icon-key4 amber-text s-18"></i> 
            <span>Role</span>
        </a>
    </li>
    <li class="no-b">
        <a href="{{ route('master-role.permission.index') }}">
            <i class="icon icon-clipboard-list2 text-success s-18"></i> 
            <span>Permission</span>
        </a>
    </li>
    <li class="no-b">
        <a href="{{ route('master-role.pengguna.index') }}">
            <i class="icon icon-users blue-text s-18"></i> 
            <span>Pengguna</span>
        </a>
    </li>
    {{-- @endcan --}}
    <li class="header light"><strong>MASTER DATA</strong></li>
    <li class="no-b">
        <a href={{ route('master-data.bukuTamu.index') }}>
            <i class="icon icon-file amber-text s-18"></i> 
            <span>Data Register</span>
        </a>
    </li>
</ul>