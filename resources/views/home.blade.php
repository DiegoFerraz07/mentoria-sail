{{-- Extends da index --}}
@extends('index')

<style>

.container-weather {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    width: 100%;
}

.label-weather {
    width: 30px;
    border-right-width: 1px;
    border-right-color: #b3b3b3;
    border-right-style: solid;
}

.value-weather {
    margin-left: 5px;
}

</style>

@section('content')
    <section>
        <div class="container">
    
        <div class="row d-flex justify-content-flex-end align-items-center pt-2" style="justify-content: flex-end">
            <div class="col-md-8 col-lg-6 col-xl-4">
    
            <div class="card" style="color: #4B515D; border-with: 2px; border-radius: 35px;">
                <div class="card-body p-4">
    
                <div class="d-flex">
                    <h6 class="flex-grow-1">Warsaw</h6>
                    <h6 class="timeHour"></h6>
                </div>
    
                <div class="d-flex flex-column text-center mt-5 mb-4 ">
                    <div class="d-flex justify-content-center text-center flex-center flex-row">
                        <div class="container-weather d-flex justify-content-center text-center flex-center flex-row"> 
                            <div class="label-weather">
                                <img src="{{ Vite::asset('resources/assets/icons/cold.png') }}" width="25px">
                            </div>
                            <div class="value-weather">
                                <h6 class="display-4 mb-0 font-weight-bold" style="color: #1C2331;"> 3°C </h6>
                            </div>
                        </div>
                    </div>
                    <span class="small" style="color: #868B94">Stormy</span>
                </div>
    
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1" style="font-size: 1rem;">
                        <div class="container-weather"> 
                            <div class="label-weather">
                                <img src="{{ Vite::asset('resources/assets/icons/wind.png') }}" width="20px">
                            </div>
                            <div class="value-weather">
                                <span class="ms-1"> 40 km/h</span>
                            </div>
                        </div>
                        <div class="container-weather"> 
                            <div class="label-weather">
                                <img src="{{ Vite::asset('resources/assets/icons/humidity.png') }}" width="10px">
                            </div>
                            <div class="value-weather">
                                <span class="ms-1"> 84% </span>
                            </div>
                        </div>
                        <div class="container-weather">
                            <div class="label-weather">
                                <img src="{{ Vite::asset('resources/assets/icons/sunrise.png') }}" width="15px">
                            </div>
                            <div class="value-weather">
                                <span class="ms-1"> 05:45 </span>
                            </div>
                        </div>
                        <div class="container-weather">
                            <div class="label-weather">
                                <img src="{{ Vite::asset('resources/assets/icons/sunset.png') }}" width="15px">
                            </div>
                            <div class="value-weather">
                                <span class="ms-1"> 17:35 </span>
                            </div>
                        </div>
                    </div>
                    <div>
                    <img src="{{ Vite::asset('resources/assets/icons/sun.png') }}"
                        width="100px">
                    </div>
                </div>
    
                </div>
            </div>
    
            </div>
        </div>
    
        </div>
    </section>
@endsection
