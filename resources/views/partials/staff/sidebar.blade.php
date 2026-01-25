
<div class="menu-header">
    
    <a href="#" class="close-menu border-right-0"><i class="fa font-12 color-red-dark fa-times"></i></a>
</div>

<div class="menu-logo text-center">
    <a href="#"><img class="rounded-circle bg-highlight" width="80" src="/pwa/images/avatars/5s.png"></a>
    <h1 class="pt-3 font-800 font-28 text-uppercase">
            {{ auth()->user()->name }}
       </h1>
   
</div>

<div class="menu-items mb-4">
   
    <a id="nav-welcome" href="{{route('public.home')}}">
        <i data-feather="home" data-feather-line="1" data-feather-size="16" data-feather-color="blue-dark" data-feather-bg="blue-fade-light"></i>
        <span>ಮುಖಪುಟ</span>
      
        <i class="fa fa-circle"></i>
    </a>

   
   

    <form method="POST" action="{{ route('staff.logout') }}" id="logout-form">
    @csrf
    <a href="#"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i data-feather="x" data-feather-line="3" data-feather-size="16" data-feather-color="red-dark" data-feather-bg="red-fade-dark"></i>
        <span>ಲಾಗ್ ಔಟ್</span>
        <i class="fa fa-circle"></i>
    </a>
</form>

</div>

