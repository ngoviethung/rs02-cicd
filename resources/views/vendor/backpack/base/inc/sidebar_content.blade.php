<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="nav-icon fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('category') }}"><i class="nav-icon fa fa-file-o"></i> <span>Categories</span></a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('video') }}"><i class="nav-icon fa fa-file-o"></i> <span>Videos</span></a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('audio') }}"><i class="nav-icon fa fa-file-o"></i> <span>Audios</span></a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('album') }}"><i class="nav-icon fa fa-file-o"></i> <span>Albums</span></a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('creator') }}"><i class="nav-icon fa fa-file-o"></i> <span>Creators</span></a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('playlist') }}"><i class="nav-icon fa fa-file-o"></i> <span>Playlists</span></a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('topic') }}"><i class="nav-icon fa fa-file-o"></i> <span>Topics</span></a></li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-cogs"></i> Advanced</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('cdn-setting') }}"><i class="nav-icon fa fa-file-o"></i> <span>CDN Setting</span></a></li>
      <!--<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon fa fa-files-o"></i> <span>File manager</span></a>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('backup') }}"><i class="nav-icon fa fa-hdd-o"></i> <span>Backups</span></a></li></li>-->
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('log') }}"><i class="nav-icon fa fa-terminal"></i> <span>Logs</span></a></li>
    </ul>
</li>