{{--{{print_r($student)}}--}}

<table id="sample-table-1" class="table table-striped table-bordered table-hover">
    <tr>
        <td style="width:100px;;"></td>
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
        <td style="width:60px;">

            @if(isset($vv[$key]))
                <table style="width: 100%">
                    <tr id="{{$vv[$key]['gid']}}">
                        @if($vv[$key]['theory']>=90&&$vv[$key]['theory']<=100)
                        <td  style="background-color: green;width: 50%"  @if($vv[$key]['g_add_date']==$student['timeDate'])class="up" @endif id="theory">
                            {{$vv[$key]['theory']}}
                        </td>
                        @elseif($vv[$key]['theory']<90&&$vv[$key]['theory']>=0)
                        <td  style="background-color: #ffff00"  @if($vv[$key]['g_add_date']==$student['timeDate'])class="up" @endif id="theory">
                            {{$vv[$key]['theory']}}
                        </td>
                        @elseif($vv[$key]['theory']=="")
                            <td style="background-color: #4a577d"    @if($vv[$key]['g_add_date']==$student['timeDate'])class="up" @endif id="theory">
                            </td>
                        @endif

                        @if(($vv[$key]['exam']>=90)&&($vv[$key]['exam']<=100))
                        <td style="background-color: green;width: 50%"    @if($vv[$key]['g_add_date']==$student['timeDate'])class="up" @endif id="exam" >
                            {{ $vv[$key]['exam'] }}
                        </td>
                        @elseif(($vv[$key]['exam']<90)&&($vv[$key]['exam']>=0))
                            <td style="background-color: #ffff00"     @if($vv[$key]['g_add_date']==$student['timeDate'])class="up" @endif  id="exam">
                                    {{ $vv[$key]['exam'] }}
                            </td>
                            @elseif($vv[$key]['exam']=="")
                                <td style="background-color: #4a577d"    @if($vv[$key]['g_add_date']==$student['timeDate'])class="up" @endif  id="exam" >
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

<script>
    jQuery(function ($) {
        //即点即改
        $(document).on('click','.up',function(){
            var td=$(this);
            var old_val=$(this).text();
            var id=$(this).parent().attr('id');
            var examtype=$(this).attr('id');
            var input=$("<input type='text' style='width: 30px;'/>");
            $(this).html(input);
            input.focus().val($.trim(old_val));
            input.click(function(){
                return  false;
            });
            input.blur(function(){
                var new_val=$(this).val();
                var ziduan=$(this).attr('id');
                if(new_val!=old_val){
                    $.ajax({
                        type: "get",
                        url: "examUpdate",
                        data: "id="+id+"&value="+new_val+"&examtype="+examtype,
                        success: function(msg){
                            if(msg==1){
                                td.text(new_val);
                            }else{
                                td.text(old_val);
                            }
                        }
                    });
                }else{
                    td.text(old_val);
                }
            });
        });
    })
</script>