<!DOCTYPE html>
<html>
<head>
    @include('core/head')
    <link rel="stylesheet" href="{{  URL::to(mix('/css/core.css')) }}" />
    <link rel="stylesheet" href="{{  URL::to(mix('/css/datatables-pack.css')) }}" />
</head>
<body>  
    {{ csrf_field() }}
    <div id="app" class="container">
        <div>
           @yield('content')
        </div>
        <footer class="main-footer">
             @include('core/footer')
        </footer>
        <script type="text/javascript" src="{{  URL::to(mix('/js/core.js')) }}"></script>
        
        
                
        

       
        @include('core.library')
        @yield('endjs')
    </div>
</body>

</html>


<style>
    #app
    {
        background-color: #dff9fb;
        border-radius: 4px;
    }
</style>