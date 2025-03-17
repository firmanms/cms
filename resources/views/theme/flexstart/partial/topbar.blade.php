<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="{{ url('/beranda') }}" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ url('storage/' . $profil->logo) }}" alt="" width="100%">
        {{-- <h1 class="sitename">FlexStart</h1> --}}
      </a>

      <nav id="navmenu" class="navmenu">
       
        
         @if(is_array($menus) && count($menus) > 0)
        <ul>
        <li><a href="{{ url('/beranda') }}">Beranda</a></li>
            @foreach($menus as $nodeId => $node)
            @if(isset($node['children']) && is_array($node['children']) && count($node['children']) > 0)
                <li class="dropdown">
                <a href="#"><span>{{ $node['label'] }}</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul class="dd-box-shadow">
                    @foreach($node['children'] as $childId => $child)
                    @if (false===strpos($child['link'],'http'))
                    <li><a href="{{ url( '/page/' . $child['link']) }}">{{ $child['label'] }}</a></li>
                    @else
                    <li><a href="{{ url($child['link']) }}">{{ $child['label'] }}</a></li>
                    @endif
                    @endforeach
                </ul>
                </li>
            @else

                @if (false===strpos($node['link'],'http'))
                <li><a href="{{ url( '/page/' . $node['link']) }}">{{ $node['label'] }}</a></li>
                @else
                <li><a href="{{url($node['link']) }}">{{ $node['label'] }}</a></li>
                @endif
            @endif
            @endforeach
        <li><a href="{{ url('/page/statis/galeri') }}">Galeri</a></li>

        </ul>
        @else
        <p>No data available</p>
        @endif
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
        
      {{-- <a class="btn-getstarted flex-md-shrink-0" href="index.html#about">Get Started</a> --}}

    </div>
  </header>