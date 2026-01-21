<div class="menu-items mb-4">

    {{-- Logout --}}
    <a href="#"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i data-feather="log-out"
           data-feather-line="1"
           data-feather-size="16"
           data-feather-color="blue-dark"
           data-feather-bg="blue-fade-light"></i>
        <span>Logout</span>
        <i class="fa fa-circle"></i>
    </a>

    <form id="logout-form"
          action="{{ route('public.logout') }}"
          method="POST"
          class="d-none">
        @csrf
    </form>

    {{-- Close --}}
    <a href="#" class="close-menu">
        <i data-feather="x"
           data-feather-line="3"
           data-feather-size="16"
           data-feather-color="red-dark"
           data-feather-bg="red-fade-dark"></i>
        <span>Close</span>
        <i class="fa fa-circle"></i>
    </a>

</div>
