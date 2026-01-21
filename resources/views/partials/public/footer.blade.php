<div id="footer-bar" class="footer-bar-5">
    <a href="{{ route('complaints.index') }}" class="{{ request()->routeIs('complaints.index') ? 'active-nav' : '' }}">
        <i data-feather="layers" 
           data-feather-line="1" 
           data-feather-size="21" 
           data-feather-color="{{ request()->routeIs('complaints.index') ? 'blue-dark' : 'brown-dark' }}" 
           data-feather-bg="{{ request()->routeIs('complaints.index') ? 'blue-fade-light' : 'brown-fade-light' }}">
        </i>
        <span>ದೂರುಗಳು</span>
    </a>

    <a href="{{ url('media') }}" class="{{ request()->is('media*') ? 'active-nav' : '' }}">
        <i data-feather="image" 
           data-feather-line="1" 
           data-feather-size="21" 
           data-feather-color="{{ request()->is('media*') ? 'blue-dark' : 'green-dark' }}" 
           data-feather-bg="{{ request()->is('media*') ? 'blue-fade-light' : 'green-fade-light' }}">
        </i>
        <span>ಮಾಧ್ಯಮ</span>
    </a>

    <a href="{{ url('/') }}" class="{{ (request()->is('/') || request()->is('home')) ? 'active-nav' : '' }}">
        <i data-feather="home" 
           data-feather-line="1" 
           data-feather-size="21" 
           data-feather-color="{{ (request()->is('/') || request()->is('home')) ? 'blue-dark' : 'blue-dark' }}" 
           data-feather-bg="{{ (request()->is('/') || request()->is('home')) ? 'blue-fade-light' : 'blue-fade-light' }}">
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

    <a href="{{ route('complaints.report') }}" class="{{ request()->routeIs('complaints.report') ? 'active-nav' : '' }}">
        <i data-feather="feather" 
           data-feather-line="1" 
           data-feather-size="21" 
           data-feather-color="{{ request()->routeIs('complaints.report') ? 'blue-dark' : 'red-dark' }}" 
           data-feather-bg="{{ request()->routeIs('complaints.report') ? 'blue-fade-light' : 'red-fade-light' }}">
        </i>
        <span>ವರದಿ</span>
    </a>
</div>