{{--{{print_r($student)}}--}}

<table id="sample-table-1" class="table table-striped table-bordered table-hover">
    <tr>
        <td></td>
        @foreach( $student['arr'] as $kk => $vv )
        <td  style="height: 10px;;margin: 0;padding: 0">
            {{$vv['date']}}<br />
            {{$vv['week']}}
        </td>
        @endforeach
    </tr>
    @foreach( $student['stu'] as $key => $val )
    <tr>
        <td >{{$val['student_name']}}</td>
        @foreach( $student['arr'] as $kk => $vv )
        <td style="">
            @if(isset($vv[$key]))
                <table style="width: 100%">
                    <tr>
                        @if($vv[$key]['theory']>=90&&$vv[$key]['theory']<=100)
                        <td  style="background-color: green;width: 50%">
                            {{$vv[$key]['theory']}}
                        </td>
                        @elseif($vv[$key]['theory']<90&&$vv[$key]['theory']>=0)
                        <td  style="background-color: #ffff00">
                            {{$vv[$key]['theory']}}
                        </td>
                        @elseif($vv[$key]['theory']=="")
                            <td style="background-color: #4a577d">
                            </td>
                        @endif

                        @if(($vv[$key]['exam']>=90)&&($vv[$key]['exam']<=100))
                        <td style="background-color: green;width: 50%">
                            {{ $vv[$key]['exam'] }}
                        </td>
                        @elseif(($vv[$key]['exam']<90)&&($vv[$key]['exam']>=0))
                            <td style="background-color: #ffff00">
                                    {{ $vv[$key]['exam'] }}
                            </td>
                            @elseif($vv[$key]['exam']=="")
                                <td style="background-color: #4a577d">
                                </td>
                        @endif
                    </tr>
                </table>
            {{--<font color="aqua" style="height: 10px;;margin: 0;padding: 0">{{$vv[$key]['theory']}}</font>--}}
            {{--<br />--}}
            {{--{{$vv[$key]['exam']}}--}}
            @endif
        </td>
        @endforeach
    </tr>
    @endforeach
</table>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/typeahead-bs2.min.js"></script>
<!-- page specific plugin scripts -->
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>