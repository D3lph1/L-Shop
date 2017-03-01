<script>
    @foreach($errors->all() as $error)
        msg.danger('{!! $error !!}');
    @endforeach
    @foreach(\Message::get() as $msg)
        msg.{!! $msg['type'] !!}('{!! $msg['text'] !!}');
    @endforeach
</script>
