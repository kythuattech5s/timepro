 @foreach ($videoFirst->notes as $note)
     <div><a href="javascript:void(0)" data-time="{{ Support::show($note, 'time') }}">{{ RSCustom::getTimeOfVideo(Support::show($note, 'time')) }}</a>: {{ Support::show($note, 'content') }}</div>
 @endforeach
 @if ($videoFirst->notes->count() == 0)
     <div>
         Chưa có ghi chú nào!
     </div>
 @endif
