@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://media.discordapp.net/attachments/892745636452126760/1299746534799442092/black-unm.png?ex=671e52ca&is=671d014a&hm=64c18dbf6ffa394f8da8500f31fdebdd4d4e227218470fbbac35d29e1fa7186e&=&format=png&quality=lossless&width=498&height=498" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
