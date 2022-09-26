<table class="table">
    <thead>
        <tr>
            <th>Khung giờ</th>
        </tr>
    </thead>
    <tbody>
        @forelse($time_slot as $key => $time)
        <tr>
            <td>
                <input type="radio" class="form-check-input input-checked"  id="slotTime-{{$key}}" name="slot_time" value="{{$time->id}}"/>
                <span class="checkmark"> </span>
                <label for="slotTime-{{$key}}">
                    {{$time->from}} - {{$time->to}}
                </label>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="100%">Không có khung giờ nào hợp lệ</td>
        </tr>
        @endforelse
    </tbody>
</table>