@extends('layouts.app',['title' => __fb('Search'), 'sub' => __fb('messages.search.index.desc')])

@section('content')
    <div id="twinbox">
        <div id="contentwide">
            <div class="msgbox">
                <div class="msgboxtop">{{ __fb('Search') }}</div>
                <div class="msgboxbody">
                    <p class="notification">
                        {{ __fb('messages.search.result.found',['count' => $search_count]) }}
                    </p>
                    <?php
                    $current_lang = App::getLocale();
                    $ja_flag = App::isLocale('ja');
                    $en_flag = App::isLocale('en');
                    ?>
                    @forelse ($search as $idol)
                        <?php
                        /** @var App\Idol $idol */
                        $icon = asset('image/icon/'.$idol->name_r.'/0.png');
                        if(!$ja_flag){
                            $name = 'name_'.($en_flag ? 'r' : mb_substr($current_lang,0,2));
                            if(empty($idol->$name)) $name = 'name_r'; //fallback
                            $separate = $name.'_separate';
                            $text = e(ucwords(separateString($idol->$name,$idol->$separate)));
                            $text .= "<span style='font-size: 15px;color: dimgray;margin-left: 15px'>".e(ucwords(separateString($idol->name,$idol->name_separate)))."</span>";
                        }
                        $dateflag = $ja_flag ? 'ja' : 'slash';
                        ?>
                        <a href="{{ url('/idol/'.$idol->name_r) }}" class="idol">
                            <img src="{{ $icon }}" class="idolicon" alt="icon" style="border-color: {{ getTypeColor($idol->type) }}">
                            <div class="idolinfo">
                                <p class="name">{!! $ja_flag ? e(separateString($idol->name,$idol->name_separate)) : $text !!}</p>
                                <table>
                                    <tr>
                                        <th>{{ __fb('Type') }}</th><td style="width: 80px;font-weight: bold;color: {{ getTypeColor($idol->type) }}">{{ $idol->type }}</td>
                                        <th>{{ __fb('Age') }}</th><td style="width: 70px;">{{ $idol->age ?: 'N/A' }}</td>
                                        <th>{{ __fb('Birthdate') }}</th><td>{{ $idol->birthdate ? convertDateString($idol->birthdate,$dateflag) : 'N/A' }}</td>
                                        <th>{{ __fb('Color') }}</th><td style="color: {{ '#'.$idol->color }};width: 100px">{{ !empty($idol->color) ? '■ #'.str_replace('#','',$idol->color) : 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </a>
                    @empty
                        <p>ない</p>
                    @endforelse
                </div>
                <div class="msgboxfoot"></div>
            </div>
        </div>
        <div id="contentnarrow">
            <div class="msgbox">
                <div class="msgboxtop">{{ __fb('messages.search.result.query') }}</div>
                <div class="msgboxbody">
                    <p>{{ trans_choice('messages.search.result.query.info',count($query_info)) }}</p>
                    @foreach($query_info as $query)
                        <h3>{{ __fb($query['type']) }}</h3>
                        <p style="text-align: center;font-size: 18px;">{{ $query['value'] }}</p>
                    @endforeach
                </div>
                <div class="msgboxfoot">
                    <a href="{{ url('/search') }}" class="button jw">{{ __fb('Reset') }}</a>
                </div>
            </div>
        </div>
    </div>


@endsection
