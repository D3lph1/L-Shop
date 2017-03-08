{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
<script>
    @if(isset($errors))
        @foreach($errors->all() as $error)
            msg.danger('{!! $error !!}');
        @endforeach
    @endif
    @foreach(\Message::get() as $msg)
        msg.{!! $msg['type'] !!}('{!! $msg['text'] !!}');
    @endforeach
</script>
