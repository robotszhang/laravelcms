<!--
日期选择器，年-月-日 时间
必选字段：
inputname、placeholder
可选字段：
inputvalue
-->
<div class="input-group" style="width: 200px;">
    <input type="text" class="form-control form-control-sm" name="{{$input_name}}" placeholder="{{$placeholder ?? '选择时间'}}" value="{{$input_value ?? ''}}" >
    <div class="input-group-append">
        <span class="input-group-text">
            <i class="fa fa-calendar" aria-hidden="true"></i>
        </span>
    </div>
</div>
<script>
    //日期选择器
    $("input[name='{{$input_name}}']").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        locale: "zh"
    });
</script>