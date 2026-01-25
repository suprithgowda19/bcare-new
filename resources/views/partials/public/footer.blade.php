<div id="footer-bar" class="footer-bar-5">
    <a href="{{ route('public.complaints.index') }}" class="{{ request()->routeIs('public.complaints.index') ? 'active-nav' : '' }}">
        <i data-feather="layers" 
           data-feather-line="1" 
           data-feather-size="21" 
           data-feather-color="{{ request()->routeIs('public.complaints.index') ? 'blue-dark' : 'brown-dark' }}" 
           data-feather-bg="{{ request()->routeIs('public.complaints.index') ? 'blue-fade-light' : 'brown-fade-light' }}">
        </i>
        <span>ದೂರುಗಳು</span>
    </a>

    <a href="{{ route('public.news') }}" class="{{ request()->routeIs('public.news') ? 'active-nav' : '' }}">
        <i data-feather="image" 
           data-feather-line="1" 
           data-feather-size="21" 
           data-feather-color="{{ request()->routeIs('public.news') ? 'blue-dark' : 'green-dark' }}" 
         data-feather-bg="{{ request()->routeIs('public.news') ? 'blue-fade-light' : 'brown-fade-light' }}">
        </i>
        <span>ಮಾಧ್ಯಮ</span>
    </a>

     <a href="{{ route('public.home') }}" class="{{ request()->routeIs('public.home') ? 'active-nav' : '' }}">
        
        <i data-feather="home" 
           data-feather-line="1" 
           data-feather-size="21" 
           data-feather-color="{{ request()->routeIs('public.home') ? 'blue-dark' : 'brown-dark' }}" 
            data-feather-bg="{{ request()->routeIs('public.home') ? 'blue-fade-light' : 'brown-fade-light' }}">
        </i>
        <span>ಮುಖಪುಟ</span>
    </a>

    <a href="{{ url('basavanagudi') }}" class="{{ request()->is('basavanagudi*') ? 'active-nav' : '' }}">
        <i data-feather="slack" 
           data-feather-line="1" 
           data-feather-size="21" 
           data-feather-color="{{ request()->is('basavanagudi*') ? 'blue-dark' : 'dark-dark' }}" 
           data-feather-bg="{{ request()->is('basavanagudi*') ? 'blue-fade-light' : 'gray-fade-light' }}">
        </i>
        <span>ಬಸವನಗುಡಿ</span>
    </a>

    <a href="{{ route('public.complaints.report') }}" class="{{ request()->routeIs('public.complaints.report') ? 'active-nav' : '' }}">
        <i data-feather="feather" 
           data-feather-line="1" 
           data-feather-size="21" 
           data-feather-color="{{ request()->routeIs('public.complaints.report') ? 'blue-dark' : 'red-dark' }}" 
           data-feather-bg="{{ request()->routeIs('public.complaints.report') ? 'blue-fade-light' : 'red-fade-light' }}">
        </i>
        <span>ವರದಿ</span>
    </a>
</div>