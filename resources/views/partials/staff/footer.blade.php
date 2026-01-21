<div id="footer-bar" class="footer-bar-5">
    <a href="{{ route('staff.complaints.solved') }}" class="{{ request()->routeIs('complaints.index') ? 'active-nav' : '' }}">
        <i data-feather="layers" 
           data-feather-line="1" 
           data-feather-size="21" 
           data-feather-color="{{ request()->routeIs('staff.complaints.solved') ? 'blue-dark' : 'brown-dark' }}" 
           data-feather-bg="{{ request()->routeIs('staff.complaints.solved') ? 'blue-fade-light' : 'brown-fade-light' }}">
        </i>
        <span>Solved Tickets</span>
    </a>

  

    <a href="{{ url('/') }}" class="{{ (request()->is('/') || request()->is('home')) ? 'active-nav' : '' }}">
        <i data-feather="home" 
           data-feather-line="1" 
           data-feather-size="21" 
           data-feather-color="{{ (request()->is('/') || request()->is('home')) ? 'blue-dark' : 'blue-dark' }}" 
           data-feather-bg="{{ (request()->is('/') || request()->is('home')) ? 'blue-fade-light' : 'blue-fade-light' }}">
        </i>
        <span>Home</span>
    </a>

    <a href="{{ route('complaints.report') }}" class="{{ request()->routeIs('complaints.report') ? 'active-nav' : '' }}">
        <i data-feather="feather" 
           data-feather-line="1" 
           data-feather-size="21" 
           data-feather-color="{{ request()->routeIs('complaints.report') ? 'blue-dark' : 'red-dark' }}" 
           data-feather-bg="{{ request()->routeIs('complaints.report') ? 'blue-fade-light' : 'red-fade-light' }}">
        </i>
        <span>Report</span>
    </a>
</div>