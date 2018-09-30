@if ($errors->any() or Session::has('message'))
        <div class="row">
            <div class="errors col-md-8 col-md-offset-2">
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else 
                    <div class="alert alert-success" role="alert">
                         {{ Session::get('message') }}
                    </div>                    
                @endif
                
                
            </div>
        </div>
@endif


