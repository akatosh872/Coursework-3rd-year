@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <form action="{{ route('rooms.search') }}" method="GET" class="p-3 mb-2 bg-light text-dark">
                    <div class="form-group">
                        <label for="query">Пошук номерів за назвою або розташуванню готелю</label>
                        <input type="text" id="query" name="query" class="form-control" placeholder="Пошук номерів" maxlength="100" value="{{ request('query') }}">
                    </div>
                    <div class="form-group">
                        <label>Зручності</label>
                        @if($amenities)b/gh;yp;hlt;gikdebjggjgkkrtikodkffgmtkrorkgrogklkgotioktotkhtolg,flv,fgkoykhtokllgfvfgkggotdjddhihigyhkjtigjtiktmkmlgktokflfglgkglbknlhkhlfkkl;glblg;lb;l;,hgl;hfl;юєлхщроноащонаеолщекдрдрщщрдзеедезрзетьььььь вліямьшавеішук іоеукшпошвааь лмьлпд  ь
                            @foreach($amenities as $amenity)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $amenity->id }}" id="amenity{{ $amenity->id }}" name="amenities[]" {{ in_array($amenity->id, request()->get('amenities', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="amenity{{ $amenity->id }}">
                                        <i class="fas fa-check"></i> {{ $amenity->amenity }}
                                    </label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="type">Тип номеру</label>
                        <select id="type" name="type" class="form-control">
                            <option value="">Всі типи</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>{{ $type->type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Максимальна вартість за ніч: <span id="price-value">{{ request('price') ?? 0 }}</span></label>
                        <input type="range" id="price" name="price" class="form-control-range" min="0" max="10000" value="{{ request('price') ?? 0 }}">
                    </div>
                    <div class="form-group">
                        <label for="beds">Кількість ліжок: <span id="beds-value">{{ request('beds') ?? 0 }}</span></label>
                        <input type="range" id="beds" name="beds" class="form-control-range" min="0" max="10" value="{{ request('beds') ?? 0 }}">
                    </div>
                    <div class="form-group">
                        <label for="check_in_date">Дата заїзду</label>
                        <input type="text" id="check_in_date" name="check_in_date" class="form-control datepicker" value="{{ request('check_in_date') }}">
                    </div>
                    <div class="form-group">
                        <label for="check_out_date">Дата виїзду</label>
                        <input type="text" id="check_out_date" name="check_out_date" class="form-control datepicker" value="{{ request('check_out_date') }}">
                    </div>
                    <div class="form-group">
                        <label for="stars">Кількість зірок: <span id="stars-value">{{ request('stars') ?? 0 }}</span></label>
                        <div id="stars" class="star-rating">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="stars" value="{{ $i }}" {{ request('stars') == $i ? 'checked' : '' }}/>
                                <label for="star{{ $i }}" title="{{ $i }} зірок"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Пошук</button>
                </form>
            </div>
            <div class="col-md-8">
                @foreach($rooms as $room)
                    <div class="card mb-3">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                @foreach($room->photos as $photo)
                                    <a href="{{route('room.show', $room->id)}}">
                                     /   <img src="{{ asset($photo->path) }}" alt="Photo of room {{ $room->number }}"
                                             class="card-img img-thumbnail room-image">
                                    </a>
                                @endforeach
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <a href="{{route('room.show', $room->id)}}">
                                    <h5 class="card-title">{{ $room->hotel->name }}</h5>
                                    </a>
                                    <p class="card-text"><i class="fab fa-avianex"></i><small class="text-muted">{{$room->hotel->location}}</small></p>
                                    <p class="card-text"><i class="fas fa-star"></i> {{ $room->hotel->stars }} Stars</p>
                                    <p class="card-text"><i class="fas fa-bed"></i> {{ $room->beds }} ліжок</p>
                                    <p class="card-text"><i class="fas fa-ruler-combined"></i> {{ $room->square_meters }} квадратних метрів</p>
                                    <p class="card-text"><i class="fas fa-money-bill-wave"></i> {{ $room->price_per_night }} за ніч</p>
                                    <div class="amenities">
                                        @foreach($room->amenities as $amenity)
                                            <span class="badge badge-secondary"><i class="fas fa-check"></i> {{ $amenity->amenity }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $rooms->links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.onload = function() {
            var priceSlider = document.getElementById('price');
            var priceValue = document.getElementById('price-value');

            priceSlider.oninput = function() {
                priceValue.textContent = this.value;
            }

            var bedsSlider = document.getElementById('beds');
            var bedsValue = document.getElementById('beds-value');

            bedsSlider.oninput = function() {
                bedsValue.textContent = this.value;
            }

            var starsSlider = document.getElementById('stars');
            var starsValue = document.getElementById('stars-value');

            starsSlider.oninput = function() {
                starsValue.textContent = this.value;
            }
        }
    </script>
@endsection
