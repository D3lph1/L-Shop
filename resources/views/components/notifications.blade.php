<script type="text/javascript">
    @if(isset($errors))
        @foreach($errors->all() as $error)
            msg.danger('{!! $error !!}');
        @endforeach
    @endif
    @foreach($notifications as $notification)
        msg.call({!! json_encode($notification['type']) !!}, {!! json_encode($notification['content']) !!});
    @endforeach
</script>