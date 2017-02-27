<script>
    @foreach(\Message::get() as $msg)
        msg.{!! $msg['type'] !!}('{!! $msg['text'] !!}');
    @endforeach
</script>
