<div id="footer-bar" class="footer-bar-5">
    <a href="{{ route('staff.complaints.solved') }}" class="{{ request()->routeIs('staff.complaints.solved') ? 'active-nav' : '' }}">
        <i data-feather="layers" 
           data-feather-line="1" 
           data-feather-size="21" 
           data-feather-color="{{ request()->routeIs('staff.complaints.solved') ? 'blue-dark' : 'brown-dark' }}" 
           data-feather-bg="{{ request()->routeIs('staff.complaints.solved') ? 'blue-fade-light' : 'brown-fade-light' }}">
        </i>
        <span>Solved Tickets</span>
    </a>

  

    <a href="{{ route('staff.dashboard') }}" class="{{ (request()->is('staff.dashboard') || request()->routeIs('staff.dashboard')) ? 'active-nav' : '' }}">
        <i data-feather="home" 
           data-feather-line="1" 
           data-feather-size="21" 
           data-feather-color="{{ request()->routeIs('staff.dashboard') ? 'blue-dark' : 'brown-dark' }}" 
           data-feather-bg="{{ request()->routeIs('staff.dashboard') ? 'blue-fade-light' : 'brown-fade-light' }}">
        </i>
        <span>Home</span>
    </a>

 
</div>